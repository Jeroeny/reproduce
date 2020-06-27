<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Gitignore matches against text.
 *
 * @author Ahmed Abdou <mail@ahmd.io>
 */
class GitignoreNew
{
    /**
     * Returns a regexp which is the equivalent of the gitignore pattern.
     *
     * @return string The regexp
     */
    public static function toRegex(string $gitignoreFileContent): string
    {
        $gitignoreFileContent = preg_replace('/^[^\\\r\n]*#.*/m', '', $gitignoreFileContent);
        $gitignoreLines = preg_split('/\r\n|\r|\n/', $gitignoreFileContent);
//        $gitignoreLines = array_map('trim', $gitignoreLines);
//        $gitignoreLines = array_filter($gitignoreLines);

        $positives = [];
        $negatives = [];
        foreach ($gitignoreLines as $i => $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            if (preg_match('/^!/', $line) === 1) {
                $positives[$i] = null;
                $negatives[$i] = self::getRegexFromGitignore(preg_replace('/^!(.*)/', '${1}', $line));

                continue;
            }
            $negatives[$i] = null;
            $positives[$i] = self::getRegexFromGitignore($line);
        }

        $patterns = [];
        foreach ($positives as $i => $pattern) {
            if ($pattern === null) {
                continue;
            }

            $negativesAfter = array_filter(array_slice($negatives, $i));
            $negativesAfter = $negativesAfter === [] ? '' : sprintf('(?<!%s)', implode('|', $negativesAfter));

            $patterns[] = sprintf('(?=%s).+%s$', $pattern, $negativesAfter);

        }

        return sprintf('/^(%s)$/', implode(')|(', $patterns));

    }

    private static function getRegexFromGitignore(string $gitignorePattern, bool $negative = false): string
    {
        $regex = '(';
        if (0 === strpos($gitignorePattern, '/')) {
            $gitignorePattern = substr($gitignorePattern, 1);
            $regex .= '^';
        } else {
//            $regex .= '(^|\/)';
//            $regex .= '^';
        }

        if ('/' === $gitignorePattern[\strlen($gitignorePattern) - 1]) {
            $gitignorePattern = substr($gitignorePattern, 0, -1);
        }

        $iMax = \strlen($gitignorePattern);
        for ($i = 0; $i < $iMax; ++$i) {
            $doubleChars = substr($gitignorePattern, $i, 2);
            if ('**' === $doubleChars) {
                $regex .= '.+';
                ++$i;
                continue;
            }

            $c = $gitignorePattern[$i];
            switch ($c) {
                case '*':
                    $regex .= '[^\/\r\n]+';
                    break;
                case '/':
                case '.':
                case ':':
                case '(':
                case ')':
                case '{':
                case '}':
                    $regex .= '\\'.$c;
                    break;
                default:
                    $regex .= $c;
            }
        }

        return $regex . ')';
    }
}
