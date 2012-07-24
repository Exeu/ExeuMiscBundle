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

namespace Exeu\MiscBundle\Tests\Validator;

use Exeu\MiscBundle\Validator\ImageDimension;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Mapping\ClassMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\StaticMethodLoader;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use \SplFileInfo;

/**
 * @author Jan Eichhorn <exeu65@googlemail.com>
 *
 */
class ImageDimensionTest extends \PHPUnit_Framework_TestCase
{
    private $imagePath = null;
    
    private $validator;

    public function setUp()
    {
        $this->imagePath = __DIR__.'/../meta/symfony_black_01.png';
        $this->validator = new Validator(
            new ClassMetadataFactory(new StaticMethodLoader()),
            new ConstraintValidatorFactory()
        );
    }
    
    /**
     * @expectedException InvalidArgumentException
     */
    public function testWrongTypeException()
    {
        $constraint = new ImageDimension(array(
            'maxDimension' => array(200, 200),
            'minDimension' => array(3000, 3000)
        ));

        $violations = $this->validator->validateValue(true, $constraint);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testWrongObjectException()
    {
        $constraint = new ImageDimension(array(
            'maxDimension' => array(200, 200),
            'minDimension' => array(3000, 3000)
        ));

        $violations = $this->validator->validateValue(new \stdClass(), $constraint);
    }   

    /**
     * @expectedException Symfony\Component\Filesystem\Exception\IOException
     */
    public function testNonExistingFileException()
    {
        $constraint = new ImageDimension(array(
            'maxDimension' => array(200, 200),
            'minDimension' => array(3000, 3000)
        ));

        $violations = $this->validator->validateValue('/foo/bar', $constraint);
    }   

    public function testInvalidFileType()
    {
        $constraint = new ImageDimension(array(
            'maxDimension' => array(200, 200),
            'minDimension' => array(3000, 3000)
        ));

        $violations = $this->validator->validateValue(__FILE__, $constraint);
        
        $this->assertEquals(1, $violations->count());
    } 

    public function testNoDimensionsPassed()
    {
        $constraint = new ImageDimension(array());

        $violations = $this->validator->validateValue($this->imagePath, $constraint);
        
        $this->assertEquals(0, $violations->count());
    } 

    public function testImageMinMaxDimension()
    {
        $constraint = new ImageDimension(array(
            'maxDimension' => array(200, 200),
            'minDimension' => array(3000, 3000)
        ));

        $violations = $this->validator->validateValue($this->imagePath, $constraint);

        $this->assertEquals(2, $violations->count());

        $constraint = new ImageDimension(array(
            'maxDimension' => array(200, 200),
            'minDimension' => array(100, 100)
        ));

        $violations = $this->validator->validateValue($this->imagePath, $constraint);
        $this->assertEquals(1, $violations->count());

        $constraint = new ImageDimension(array(
            'maxDimension' => array(3000, 3000),
            'minDimension' => array(100, 100)
        ));

        $violations = $this->validator->validateValue($this->imagePath, $constraint);
        $this->assertEquals(0, $violations->count());
    }

    public function testImageMinDimension()
    {
        $constraint = new ImageDimension(array(
            'minDimension' => array(200, 200)
        ));

        $violations = $this->validator->validateValue($this->imagePath, $constraint);
        $this->assertEquals(0, $violations->count());

        $constraint = new ImageDimension(array(
            'minDimension' => array(3000, 3000)
        ));

        $violations = $this->validator->validateValue($this->imagePath, $constraint);
        $this->assertEquals(1, $violations->count());
    }

    public function testImageMaxDimension()
    {
        $constraint = new ImageDimension(array(
            'maxDimension' => array(200, 200)
        ));

        $violations = $this->validator->validateValue($this->imagePath, $constraint);
        $this->assertEquals(1, $violations->count());

        $constraint = new ImageDimension(array(
            'maxDimension' => array(3000, 3000)
        ));

        $violations = $this->validator->validateValue($this->imagePath, $constraint);
        $this->assertEquals(0, $violations->count());
    }

    public function testImageDimensionWithFileInfo()
    {
        $fileInfo = new SplFileInfo($this->imagePath);

        $constraint = new ImageDimension(array(
            'maxDimension' => array(200, 200)
        ));

        $violations = $this->validator->validateValue($fileInfo, $constraint);
        $this->assertEquals(1, $violations->count());

        $constraint = new ImageDimension(array(
            'maxDimension' => array(3000, 3000)
        ));

        $violations = $this->validator->validateValue($fileInfo, $constraint);
        $this->assertEquals(0, $violations->count());
    }
}