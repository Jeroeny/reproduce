<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/Gitignore.php';

$files = [
    'example/example.txt',
    'example/test',
    'example/packages/file.yaml',
    'example/packages/example.yaml',
    'example/foo/bar.txt',
    'test/bar',
    'test/bar/',
];

$regex = \Symfony\Component\Finder\Gitignore::toRegex(file_get_contents(__DIR__ . '/.gitignore'));

test($regex, $files);

$fixedRegex = \Gitignore::toRegex(file_get_contents(__DIR__ . '/.gitignore'));

test($fixedRegex, $files);

function test(string $pattern, array $files) {
    echo $pattern . PHP_EOL;

    foreach ($files as $file) {
        $match = preg_match($pattern, $file) === 1;
        echo $file . ' ignored: ' . var_export($match, true) . PHP_EOL;
    }
}
