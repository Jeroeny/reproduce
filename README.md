# reproduce

Given the following route annotion configuration (`config/routes/annotations.yaml`):

```yaml
controllers_good:
    resource: ../../src/Controller/Good/*
    type: annotation
    exclude: '../../src/Controller/Good/{ExcludeController}.php'
    prefix: '/good'

controllers_bad:
    resource: ../../src/Controller/Bad/
    type: annotation
    exclude: '../../src/Controller/Bad/{ExcludeController}.php'
    prefix: '/bad'
```
The expected result would be:

```bash

./bin/console debug:router
 ----------------------- -------- -------- ------ --------------------------
  Name                    Method   Scheme   Host   Path                     
 ----------------------- -------- -------- ------ --------------------------
  _preview_error          ANY      ANY      ANY    /_error/{code}.{_format}
  app_good_one_index      ANY      ANY      ANY    /good/one
  app_bad_one_index       ANY      ANY      ANY    /bad/one
 ----------------------- -------- -------- ------ --------------------------

```

But the actual result is:

```bash

./bin/console debug:router
 ----------------------- -------- -------- ------ --------------------------
  Name                    Method   Scheme   Host   Path                     
 ----------------------- -------- -------- ------ --------------------------
  _preview_error          ANY      ANY      ANY    /_error/{code}.{_format}
  app_good_one_index      ANY      ANY      ANY    /good/one
  app_bad_exclude_index   ANY      ANY      ANY    /bad/exclude
  app_bad_one_index       ANY      ANY      ANY    /bad/one
 ----------------------- -------- -------- ------ --------------------------

```

With the difference being the added:

```
  app_bad_exclude_index   ANY      ANY      ANY    /bad/exclude
```

route, which must be excluded. However, it only works when `resource: ` contains one of `*{}[]?` characters.
