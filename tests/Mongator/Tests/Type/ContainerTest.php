<?php

/*
 * This file is part of Mongator.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mongator\Tests\Type;

use Mongator\Type\Container;
use Mongator\Type\Type;

class TestingType extends Type
{
    public function toMongo($value)
    {
    }

    public function toPHP($value)
    {
    }

    public function toMongoInString()
    {
    }

    public function toPHPInString()
    {
    }
}

class ContainerTest extends TestCase
{
    public function testHas()
    {
        $this->assertTrue(Container::has('string'));
        $this->assertFalse(Container::has('no'));
    }

    public function testAdd()
    {
        Container::add('testing', 'Mongator\Tests\Type\TestingType');
        $this->assertTrue(Container::has('testing'));

        $this->assertInstanceOf('Mongator\Tests\Type\TestingType', Container::get('testing'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddAlreadyExists()
    {
        Container::add('string', 'Mongator\Tests\Type\TestingType');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAddClassNotSubclassType()
    {
        Container::add('testing', '\DateTime');
    }

    public function testGet()
    {
        $string = Container::get('string');
        $float  = Container::get('float');

        $this->assertInstanceOf('Mongator\Type\StringType', $string);
        $this->assertInstanceOf('Mongator\Type\FloatType', $float);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetNotExists()
    {
        Container::get('no');
    }

    public function testRemove()
    {
        Container::remove('string');
        $this->assertFalse(Container::has('string'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRemoveNotExists()
    {
        Container::remove('no');
    }

    public function testResetTypes()
    {
        Container::add('testing', 'Mongator\Tests\Type\TestingType');
        Container::reset();

        $this->assertTrue(Container::has('string'));
        $this->assertFalse(Container::has('testing'));
    }
}
