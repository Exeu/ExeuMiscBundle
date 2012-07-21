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

namespace Exeu\MiscBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint for an ImageDimension
 * @Annotation
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ImageDimension extends Constraint
{
    public $minDimension = array();
    public $maxDimension = array();
    public $minMessage = "The image is to small. At min: %width%x%height%!";
    public $maxMessage = "The image is to big. At max: %width%x%height%!";

    /**
     * {@inheritDoc}
     */
    public function getRequiredOptions()
    {
        return array();
    }

    /**
     * The validator must be defined as a service with this name.
     *
     * @return string
     */
    public function validatedBy()
    {
        return "exeu.extra.validator.imagedimension";
    }


    /**
     * {@inheritDoc}
     */
    public function getTargets()
    {
        return self::PROPERTY_CONSTRAINT;
    }
}