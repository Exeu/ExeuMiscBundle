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

Dont forget to activate the bundle in your AppKernel:

``` php
<?php

// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Exeu\MiscBundle\ExeuMiscBundle(),
    // ...
);

```

## Usage ##

### Twig ###

#### asset_url ####

To get an URL of your asset you can user the following twig function:

``` html
<img src="{{ asset_url('bundles/acmebundle/images/image.jpg') }}">
```

### Doctrine ###

#### RAND() ####

With this bundle you can activate the MySQL RAND() Function.

You have to add the following to your config.yml:

``` yaml
# app/config/config.yml

doctrine:

    orm:
        # ...
        entity_managers:
            default:
                auto_mapping: true
                dql:
                    numeric_functions:
                        RAND: Exeu\MiscBundle\Doctrine\Extension\Rand
```

If you have done this you can use the RAND() Function in your DQL Select Part:

``` php
<?php
...
$em = $this->getDoctrine()->getEntityManager();
$query = $em->createQuery("SELECT p, RAND() as c FROM AcmeTestBundle:User p ORDER BY c");
$randomUsers = $query->getResult();
...
```