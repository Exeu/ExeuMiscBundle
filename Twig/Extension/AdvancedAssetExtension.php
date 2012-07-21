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

namespace Exeu\MiscBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A advanced assets implementation.
 *
 * This class provides some usefull functions extending the twig asset management.
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class AdvancedAssetExtension extends \Twig_Extension {

    private $container;
    private $staticHost = null;

    /**
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param boolean $staticHost The static host URL
     */
    public function __construct(ContainerInterface $container, $staticHost = null)
    {
        $this->staticHost = $staticHost;
        $this->container = $container;
    }

    /**
     * Returns a list of functions to add to the existing list.
     *
     * @return array An array of functions
     */
    public function getFunctions()
    {
        return array(
            'asset_url' => new \Twig_Function_Method($this, 'getAssetUrl'),
        );
    }

    /**
     * Returns the public URL of an asset.
     *
     * @param string $path        A public path
     * @param boolean $useStaticHost  Use the static host var?
     * @param string $packageName The name of the asset package to use
     *
     * @return string A public URL which takes into account the base path and URL path
     */
    public function getAssetUrl($path, $useStaticHost = false, $packageName = null)
    {
        return $this->addSchemeAndHost($this->container->get('templating.helper.assets')->getUrl($path, $packageName), $useStaticHost);
    }

    /**
     * Concats the AssetPath with scheme and hostname from request or an statichost
     *
     * @param string  $path           A public path
     * @param boolean $useStaticHost  Use the static host var?
     *
     * @return string A public URL which takes into account the base path and URL path
     */
    private function addSchemeAndHost($path, $useStaticHost = false)
    {
        $host = "";
        if (false === $useStaticHost) {
            $request = $this->container->get('request');
            $host = $request->getScheme() . "://" . $request->getHost();
        } else {
            $host = $this->staticHost;
        }

        return  $host . $path;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'advanced_asset';
    }
}