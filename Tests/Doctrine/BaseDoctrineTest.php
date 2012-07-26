<?php
/*
 * Copyright 2012 Jan Eichhorn <exeu65@googlemail.com>
*
* Licensed under the Apache License, Version 2.0 (the "License");
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
* http://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an "AS IS" BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/

namespace Exeu\MiscBundle\Tests\Doctrine;

/**
 * @author Jan Eichhorn <exeu65@googlemail.com>
 *
 */
abstract class BaseDoctrineTest extends \PHPUnit_Framework_TestCase
{
    protected $entityManager;

    public function setUp()
    {
        $config = new \Doctrine\ORM\Configuration();
        $config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache());
        $config->setProxyDir('/tmp/');
        $config->setProxyNamespace('Proxie');
        $config->setAutoGenerateProxyClasses(true);

        $driver = $config->newDefaultAnnotationDriver(__DIR__.'/Entities', false);
        $config->setMetadataDriverImpl($driver);

        $config->addCustomNumericFunction('RAND', "Exeu\MiscBundle\Doctrine\Extension\Rand");
        $conn = array(
            'driver' => 'pdo_sqlite',
            'memory' => true,
        );
        
        $evm = new \Doctrine\Common\EventManager();
        
        $this->entityManager = \Doctrine\ORM\EntityManager::create($conn, $config, $evm);
    }
}