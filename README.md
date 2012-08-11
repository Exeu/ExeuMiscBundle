Exeu Misc Bundle
========================

## Build Status ##

Travis:

[![Build Status](https://secure.travis-ci.org/Exeu/ExeuMiscBundle.png?branch=master)](http://travis-ci.org/Exeu/ExeuMiscBundle)

Jenkins:

[![Build Status](http://ci.pixel-web.org/job/ExeuMiscBundle/badge/icon)](http://ci.pixel-web.org/job/ExeuMiscBundle/)

## Installation

### Symfony 2.0.x

Add the following lines in your `deps` file:

``` ini
[ExeuMiscBundle]
    git=git://github.com/Exeu/ExeuMiscBundle.git
    target=bundles/Exeu/MiscBundle
```

Modify the autoload.php:

``` php
<?php

// app/autoload.php
$loader->registerNamespaces(array(
    // ...
    'Exeu'              => __DIR__.'/../vendor/bundles',
    // ...
));
```

Now run the vendors script:

``` bash
$ php bin/vendors install
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

**asset_url**

To get an URL of your asset you can user the following twig function:

``` html
<img src="{{ asset_url('bundles/acmebundle/images/image.jpg') }}">
```

You also can setup an statichost in your config.yml:

``` yaml
# app/config/config.yml

exeu_misc:
    twig:
        staticHost: http://mystatic.image.host.com
```

To use this statichost URL call the asset_url function with the second parameter set to true:

``` html
<img src="{{ asset_url('bundles/acmebundle/images/image.jpg', true) }}">
```

This could be usefull if you generate templates with the CLI.

### Doctrine ###

**RAND()**

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

(See: [Registering Custom DQL Functions](http://symfony.com/doc/current/cookbook/doctrine/custom_dql_functions.html) )

If you have done this you can use the RAND() Function in your DQL Select Part:

``` php
<?php
// ...
$em = $this->getDoctrine()->getEntityManager();
$query = $em->createQuery("SELECT p, RAND() as c FROM AcmeTestBundle:User p ORDER BY c");
$randomUsers = $query->getResult();
// ...
```

**Tableprefix**

To set up a tableprefix wich affects all your entitys you can use the provided tableprefix class.

The only thing you have to do is to enable the service in your config file:

``` yaml
# app/config/config.yml

services:
    exeu.misc.doctrine.tableprefix:
        class: Exeu\MiscBundle\Doctrine\TablePrefix
        arguments: ["myprefix_"]
        public: false
        tags:
          - { name: doctrine.event_subscriber }
```

Now if you are creating your schema, all tables will be prefixed with "myprefix_".

### Validation ###

**ImageDimension**

To validate the dimension of an Image you can use the ImageDimension-Validator provided with this bundle:

``` php
<?php
// ...
use Exeu\MiscBundle\Validator\ImageDimension;
// ...
/**
 * @ORM\Entity
 */
class Test
{
    // ...

    /**
     * @ImageDimension(minDimension={422, 422}, maxDimension={500, 100})
     */
    public $file;
```

The $file property either can be a string or an object.

``` php
<?php
// ...
public function buildForm(FormBuilderInterface $builder, array $options)
{
    // an object example
    $builder->add('file', 'file');

    // an string example
    $builder->add('file', 'text');
}
```
Annotation description:

``` php
<?php
/**
 * @ImageDimension(minDimension={422, 422}, maxDimension={500, 100}, minMessage="The image is to small. At min: %width%x%height%!", maxMessage="The image is to big. At max: %width%x%height%!", invalidFileMessage="The file you provided is no valid image!")
 */
public $file;
```

minDimension -> an array of width an height in px

maxDimension -> an array of width an height in px

minMessage -> The message that should be displayed when the image is to small (placeholder %width%, %height%)

maxMessage -> The message that should be displayed when the image is to big (placeholder %width%, %height%)

invalidFileMessage -> The message that shold be displayed when the file is no valid image

**If you only provide either minDimension or maxDimension your image will validate only against this dimension**

**Combine it with the Symfony ImageValidator**

``` php
<?php
// ...
/**
 * @Assert\Image(maxSize="1M", mimeTypes={"image/gif", "image/jpeg", "image/png"})
 * @ImageDimension(minDimension={422, 422})
 */
private $file;
// ...
```

### Cache ###

Sometimes it is usefull to use a PHPCache like APC to store some variables or complex objects directly in the shared memory of the server to get very fast access.

For this reason there is a so called cachmanager provided in this bundle.

To activate this cachemanager you have to enable it in your config:

``` yaml
# app/config/config.yml

exeu_misc:
    cache: ~
```

Now you can access the cachemanager for example in your controller:

``` php
<?php
// ...
$cacheManager = $this->get('exeu.extra.cache.manager');
$cacheManager = $this->get('ex.cache'); // Shortcut

$data = array('foo' => 'bar');
$cacheManager->write('my_key', $data);

// ...

$data = $cacheManager->read('my_key');

// ...

$cacheManager->delete('my_key');
// ...
```

For full information about the functions you can call see Exeu\MiscBundle\Cache\CacheManager

By default the cachmanager uses a APC cachedriver: Exeu\MiscBundle\Cache\Driver\APC

This class can be changed in your config:

``` yaml
# app/config/config.yml

exeu_misc:
    cache:
      driver_class: Exeu\MiscBundle\Cache\Driver\xCache
```

You can implement your own cachedriver by creating a class which implements Exeu\MiscBundle\Cache\Driver\DriverInterface

``` yaml
# app/config/config.yml

exeu_misc:
    cache:
      driver_class: Acme\DemoBundle\MyCache\Driver\FooDriver
```