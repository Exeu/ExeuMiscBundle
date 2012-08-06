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

namespace Exeu\MiscBundle\Cache\Driver;

/**
 * A APC implementation 
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class APC implements DriverInterface
{
    /**
     * {@inheritDoc}
     */
    public function read($id)
    {
        return unserialize(apc_fetch($id));
    }

    /**
     * {@inheritDoc}
     */
    public function write($id, $data, $ttl = 0)
    {
        return apc_store($id, serialize($data), $ttl);
    }

    /**
     * {@inheritDoc}
     */
    public function delete($id)
    {
        return apc_delete($id);
    }

    /**
     * {@inheritDoc}
     */
    public function acceleratorName()
    {
        return 'apc';
    }
}
