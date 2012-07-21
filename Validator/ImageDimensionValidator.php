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
use Symfony\Component\Validator\ConstraintValidator;

/**
 * ImageDimension Validator
 *
 * @author Jan Eichhorn <exeu65@googlemail.com>
 */
class ImageDimensionValidator extends ConstraintValidator
{
    private $constraint;
    private $dimensions;

    /**
     * @param object     $file
     * @param Constraint $constraint
     *
     * @return bool
     */
    public function isValid($file, Constraint $constraint)
    {
        $this->dimensions = getimagesize($file->getPathname());
        $this->constraint = $constraint;

        if (false === $this->checkMinDimensions() || false === $this->checkMaxDimensions()) {
            return false;
        }

        return true;
    }

    private function checkMaxDimensions()
    {
        if (true === empty($this->constraint->maxDimension)) {
            return true;
        }

        if ($this->dimensions[0] > $this->constraint->maxDimension[0] || $this->dimensions[1] > $this->constraint->maxDimension[1]) {
           $this->context->addViolation($this->constraint->maxMessage, array(
               '%width%' => $this->constraint->maxDimension[0],
               '%height%' => $this->constraint->maxDimension[1]
            ));

            return false;
        }

        return true;
    }

    private function checkMinDimensions()
    {
        if (true === empty($this->constraint->minDimension)) {
            return true;
        }

        if ($this->dimensions[0] < $this->constraint->minDimension[0] || $this->dimensions[1] < $this->constraint->minDimension[1]) {
           $this->context->addViolation($this->constraint->minMessage, array(
               '%width%' => $this->constraint->minDimension[0],
               '%height%' => $this->constraint->minDimension[1]
            ));

            return false;
        }

        return true;
    }
}