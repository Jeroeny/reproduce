# Reproduce

The `Symfony\Component\Serializer\Annotation\Ignore` attribute causes the `Bad::id` property to be ignored for unknown reasons. It happens only when some methods are marked with the attribute.

To install: `composer install`.

Run with `./bin/console run`. 

Output:

```
$ ./bin/console run
BadOne: {"foo":"foo"}
GoodOne: {"foo":"foo","id":"99287524-4bbe-4ec7-be12-1d6be12de209"}
```

Expected:

```
$ ./bin/console run
BadOne: {"foo":"foo","id":"99287524-4bbe-4ec7-be12-1d6be12de209"}
GoodOne: {"foo":"foo","id":"99287524-4bbe-4ec7-be12-1d6be12de209"}
```