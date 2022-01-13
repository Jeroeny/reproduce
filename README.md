# Reproduce

The `Symfony\Component\Serializer\Annotation\Ignore` attribute causes the `Bad::id` property to be ignored for unknown reasons. It happens only when some methods are marked with the attribute.

To install: `composer install`.

Run with `./bin/console run`. 

Output:

```
$ ./bin/console run
BadOne: {"foo":"foo"}
BadTwo: {"id":"71823347-c22b-4e22-92c1-a16bf48be703","create":false}
GoodOne: {"foo":"foo","id":"4f886c3c-c026-49c3-a7de-f56631cbc1b1"}
```

Expected:

```
$ ./bin/console run
BadOne: {"foo":"foo","id":"99287524-4bbe-4ec7-be12-1d6be12de209"}
BadTwo: {"id":"71823347-c22b-4e22-92c1-a16bf48be703","create":false,"delete":false}
GoodOne: {"foo":"foo","id":"99287524-4bbe-4ec7-be12-1d6be12de209"}
```
