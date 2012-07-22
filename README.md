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

(See: [Registering Custom DQL Functiona](http://symfony.com/doc/current/cookbook/doctrine/custom_dql_functions.html) )

If you have done this you can use the RAND() Function in your DQL Select Part:

``` php
<?php
...
$em = $this->getDoctrine()->getEntityManager();
$query = $em->createQuery("SELECT p, RAND() as c FROM AcmeTestBundle:User p ORDER BY c");
$randomUsers = $query->getResult();
...
```

### Validation ###

**ImageDimension**

To validate the dimension of an Image you can use the ImageDimension-Validator provided with this bundle:

``` php
<?php
...
use Exeu\MiscBundle\Validator\ImageDimension;
...
/**
 * @ORM\Entity
 */
class Test
{
    ...

    /**
     * @ImageDimension(minDimension={422, 422}, maxDimension={500, 100})
     */
    public $file;
```

The $file property either can be a string or an object.

``` php
<?php
...
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