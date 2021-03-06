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

namespace Exeu\MiscBundle\Cache;

use Exeu\MiscBundle\Cache\Driver\DriverInterface;

/**
 * The Cachemanager
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class CacheManager
{
    protected $cacheDriver;

    /**
     * Constructor
     *
     * @param DriverInterface $cacheDriver
     */
    public function __construct(DriverInterface $cacheDriver)
    {
        $this->cacheDriver = $cacheDriver;
        $this->checkDriver();
    }

    /**
     * Writes an cache entry
     *
     * @param string  $key  The cache key
     * @param mixed   $data The data to be stored
     * @param integer $ttl  Time to life for this cache entry
     *
     * @return boolean True=Success|False=No success
     */
    public function write($key, $data, $ttl = 0)
    {
        return $this->cacheDriver->write($key, $data, $ttl);
    }

    /**
     * Deletes an cache entry
     *
     * @param string $key The cache key
     *
     * @return boolean True=Success|False=No success
     */
    public function delete($key)
    {
        return $this->cacheDriver->delete($key);
    }

    /**
     * Reads an cache entry
     *
     * @param string $key The cache key
     *
     * @return mixed
     */
    public function read($key)
    {
        return $this->cacheDriver->read($key);
    }

    protected function checkDriver()
    {
        if (false === extension_loaded($this->cacheDriver->acceleratorName())) {
            throw new \InvalidArgumentException(sprintf("The cachedriver %s could not be loaded. Please check if the PHPExtension is installed on your system!", $this->cacheDriver->acceleratorName()));
        }
    }
}