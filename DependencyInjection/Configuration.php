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

namespace Exeu\MiscBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('exeu_misc')
            ->children()
                ->arrayNode('twig')
                ->children()
                    ->scalarNode('staticHost')
                        ->cannotBeEmpty()
                        ->defaultNull()
                    ->end()
                ->end()
                ->end()
                ->arrayNode('cache')
                ->children()
                    ->scalarNode('driver_class')
                        ->cannotBeEmpty()
                        ->defaultNull()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
