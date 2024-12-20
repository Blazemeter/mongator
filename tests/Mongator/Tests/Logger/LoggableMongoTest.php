<?php

/*
 * This file is part of Mongator.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mongator\Tests\Logger;

use Mongator\Logger\LoggableMongo;

class LoggableMongoTest extends \PHPUnit\Framework\TestCase
{
    protected $log;

    protected function setUp(): void
    {
        if (!class_exists('Mongo')) {
            $this->markTestSkipped('Mongo is not available.');
        }
    }

    public function testLoggerCallable()
    {
        $mongo = new LoggableMongo();

        $mongo->setLoggerCallable($loggerCallable = function() {});

        $this->assertSame($loggerCallable, $mongo->getLoggerCallable());
    }

    public function testLogDefault()
    {
        $mongo = new LoggableMongo();

        $mongo->setLogDefault($logDefault = array('connection' => 'default'));

        $this->assertSame($logDefault, $mongo->getLogDefault());
    }

    public function testLog()
    {
        $mongo = new LoggableMongo();
        $mongo->setLoggerCallable(array($this, 'log'));

        $mongo->log($log = array('foo' => 'bar'));

        $this->assertSame($log, $this->log);
    }

    public function testLogWithLogDefault()
    {
        $mongo = new LoggableMongo();
        $mongo->setLoggerCallable(array($this, 'log'));
        $mongo->setLogDefault($logDefault = array('connection' => 'default', 'foo' => 'foobar'));

        $mongo->log($log = array('foo' => 'bar'));

        $this->assertSame(array_merge($logDefault, $log), $this->log);
    }

    public function log(array $log)
    {
        $this->log = $log;
    }

    public function testSelectDB()
    {
        $mongo = new LoggableMongo();
        $db = $mongo->selectDB('mongator_logger');

        $this->assertInstanceOf('\Mongator\Logger\LoggableMongoDB', $db);
        $this->assertSame('mongator_logger', $db->__toString());
    }

    public function test__get()
    {
        $mongo = new LoggableMongo();
        $db = $mongo->mongator_logger;

        $this->assertInstanceOf('\Mongator\Logger\LoggableMongoDB', $db);
        $this->assertSame('mongator_logger', $db->__toString());
    }
}
