Exeu Misc Bundle
========================

## Installation

### Symfony 2.0.x

Add the following lines in your `deps` file:

``` ini
[ExeuMiscBundle]
    git=git://github.com/Exeu/ExeuMiscBundle.git
    target=bundles/Exeu/MiscBundle
```

### Symfony 2.1.x

Add ExeuMiscBundle in your composer.json:

```js
{
    "require": {
        "exeu/misc-bundle": "dev-master"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update exeu/misc-bundle
```
