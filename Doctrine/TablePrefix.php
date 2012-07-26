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

namespace Exeu\MiscBundle\Doctrine;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

/**
 * Doctrine TablePrefix implementation
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class TablePrefix implements EventSubscriber
{
    private $prefix = null;

    /**
     * @param string $prefix
     */
    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }

    /**
     * @param Doctrine\ORM\Event\LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetaData(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $classMetadata->setTableName($this->prefix . $classMetadata->getTableName());
        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if (\Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY == $mapping["type"]) {
                $mappedTableName = $classMetadata->associationMappings[$fieldName]["joinTable"]["name"];
                $classMetadata->associationMappings[$fieldName]["joinTable"]["name"] = $this->prefix . $mappedTableName;
            }
        }
    }

    /**
     * Returns all Events that this class is listen to
     *
     * @return array
     *
     * @see \Doctrine\Common\EventSubscriber::getSubcribedEvents
     */
    public function getSubscribedEvents()
    {
        return array(\Doctrine\ORM\Events::loadClassMetadata);
    }
}