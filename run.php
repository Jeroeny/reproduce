<?php

require __DIR__ . '/vendor/autoload.php';

$regex = \Symfony\Component\Finder\Gitignore::toRegex(file_get_contents(__DIR__ . '/.gitignore'));

$files = [
    'example/example.txt',
    'example/packages/file.yaml',
    'example/packages/example.yaml',
    'example/foo/bar.txt',
];
foreach ($files as $file) {
    $match = preg_match($regex, $file) === 1;
    echo $file . ' ignored: ' . var_export($match, true) . PHP_EOL;
}
