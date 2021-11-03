# Reproduce

There is a memory leak when reading from Symfony's cache. Issue: https://github.com/symfony/symfony/issues/43918

To reproduce:

```bash
./bin/console -vvv run -e prod
Memory: 8.9726409912109 MB
Memory: 13.854598999023 MB
Memory: 13.903198242188 MB
Memory: 13.971328735352 MB
Memory: 13.994583129883 MB
Memory: 14.094024658203 MB
Memory: 14.115341186523 MB
Memory: 14.138595581055 MB
Memory: 14.161849975586 MB
Memory: 14.183166503906 MB
Memory: 14.206420898438 MB
```

I was able to test on PHP 8.0.11 on both Windows and a Docker container based on Debian. 

I prefer to test this with `APP_ENV=prod`, otherwise tracing/profiling versions of the CacheAdapter may keep traces of cache calls which increase memory and may be neglected. 

The memory increase may not be significant in this example. In our own application, the increase is 10 MB per call to the method that does a bunch of caching.
This caused our message consumers to go Out-of-Memory within seconds. Sometimes they couldn't even start consuming.

In our own application, we were able to mitigate the problem by calling PHP's `gc_collect_cycles()` function. Unfortunately, I've not been able to reproduce that in this project.
Another difference that is that in our app the cache returned instances of PHP classes, here I made it return `composer.lock` contents, just to have some data going through. 

This project has been created using `symfony new app` (https://symfony.com/doc/current/setup.html).
No files were altered generating except `composer.json` (`"require": {"php": ">=8.0", `) and the `src/Run.php` was added.
