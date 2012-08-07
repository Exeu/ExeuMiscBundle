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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * ExeuMiscExtension
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ExeuMiscExtension extends Extension
{
    private $loader;

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $this->loadTwig($config, $container);

        if (true === isset($config['cache'])) {
            $this->loadCache($config, $container);
        }
    }

    /**
     * Loads the Twig Extensions
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    protected function loadTwig(array $config, ContainerBuilder $container)
    {
        $this->loader->load('twig.xml');
        if (false === empty($config['twig']['staticHost'])) {
            $container->getDefinition('exeu.extra.twig.advancedassets')->replaceArgument(1, $config['twig']['staticHost']);
        }
    }

    /**
     * Loads the Cache Extension
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    protected function loadCache(array $config, ContainerBuilder $container)
    {
        $this->loader->load('cache.xml');
        if (false === empty($config['cache']['driver_class'])) {
            $container->getDefinition('exeu.extra.cache.driver')->setClass($config['cache']['driver_class']);
        }
    }
}