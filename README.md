# reproduce

This is a reproducer to show a bug in the `\Symfony\Component\Finder\Gitignore::toRegex()` functionality.

When you want to ignore everything in a certain directory, _except_ some specific files,
these are the `.gitignore` rules that can be used:
```gitignore
/example/**
!/example/example.txt
!/example/packages/
!/example/packages/example.yaml
``` 

You might think `/example/packages/` will be unignored by this, but that is not the case according to the `.gitignore` standard.
With this setup, any other files in `/example/packages/` will be ignored. But the `Gitignore::toRegex` does not match this logic properly.

See also: https://git-scm.com/docs/gitignore and https://stackoverflow.com/a/61556103/3265437

### Install

```
composer install
```

### Usage


Run the script:
```bash
$ php ./run.php

/(?=^(?:(?!((^example\/example\.txt($|\/))|(^example\/packages($|\/))|(^example\/packages\/example\.yaml($|\/))|(^example\/test($|\/)))).)*$)((^\.idea($|\/))|(^build($|\/))|(^vendor($|\/))|(^example\/.+($|\/))|((^|\/)test\/bar($|\/)))/
example/example.txt ignored: false
example/test ignored: false
example/packages/file.yaml ignored: false
example/packages/example.yaml ignored: false
example/foo/bar.txt ignored: true
test/bar ignored: true
test/bar/ ignored: true

/(?=^(?:(?!((^example\/example\.txt($))|(^example\/packages($))|(^example\/packages\/example\.yaml($))|(^example\/test\/($)))).)*$)((^\.idea\/($|\/))|(^build\/($|\/))|(^vendor\/($|\/))|(^example\/.+($|\/))|((^|\/)test\/bar\/($|\/)))/
example/example.txt ignored: false
example/test ignored: true
example/packages/file.yaml ignored: true
example/packages/example.yaml ignored: false
example/foo/bar.txt ignored: true
test/bar ignored: false
test/bar/ ignored: true
```

Which should give that output.
The first regex is the one of the current (4.3 - master) Symfony finder. Including paths and there outcome.
The second regex is the one of the `Gitignore.php` in this project. Which contains a possible fix.

The expected output is:
 ```bash
example/example.txt ignored: false
example/packages/file.yaml ignored: true
example/packages/example.yaml ignored: false
example/foo/bar.txt ignored: true
```

The `example/packages/file.yaml` is not correctly seen as ignored, actually any file inside `example/packages/` is seen as not ignored.

Actual ignored and tracked files using `git` CLI:

```bash
# create some test files
$ touch example/foo/bar.txt
$ touch example/packages/file.yaml

# show ignored files
$ git ls-files example/ --ignored --exclude-standard --others
example/foo/bar.txt
example/packages/file.yaml

# show tracked files
$ git ls-files example/
example/example.txt
example/packages/example.yaml
```
