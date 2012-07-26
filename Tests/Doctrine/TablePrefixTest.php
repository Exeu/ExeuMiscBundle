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
class TablePrefixTest extends BaseDoctrineTest
{
    public function setUp()
    {
        parent::setUp();
        
        $tablePrefix = new \Exeu\MiscBundle\Doctrine\TablePrefix("myprefix_");
        $this->entityManager->getEventManager()->addEventSubscriber($tablePrefix);
    }
    
    public function testTablePrefix()
    {
        $dql = "SELECT t FROM Exeu\MiscBundle\Tests\Entities\TestEntity t";
        $query = $this->entityManager->createQuery($dql);
        
        $expectedSql = "SELECT m0_.id AS id0, m0_.name AS name1 FROM myprefix_TestEntity m0_";
        $this->assertEquals($expectedSql, $query->getSql());
    }
}