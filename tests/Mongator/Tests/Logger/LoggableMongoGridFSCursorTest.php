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

use Mongator\Tests\TestCase;
use Mongator\Logger\LoggableMongo;
use Mongator\Logger\LoggableMongoGridFSCursor;

class LoggableMongoGridFSCursorTest extends TestCase
{
    protected $log;
    
    protected function setUp(): void
    {
        if (!class_exists('Mongo')) {
            $this->markTestSkipped('Mongo is not available.');
        }
    }
    
    public function testConstructorAndGetCollection()
    {
        $mongo = new LoggableMongo();
        $db = $mongo->selectDB('Mongator_logger');
        $grid = $db->getGridFS('Mongator_logger_grid');

        $cursor = new LoggableMongoGridFSCursor($grid);

        $this->assertSame($grid, $cursor->getGrid());
    }

    public function testLog()
    {
        $mongo = new LoggableMongo();
        $mongo->setLoggerCallable(array($this, 'log'));
        $db = $mongo->selectDB('Mongator_logger');
        $grid = $db->getGridFS('Mongator_logger_grid');
        $cursor = $grid->find();

        $cursor->log($log = array('foo' => 'bar'));

        $this->assertSame(array_merge(array(
            'database'   => 'Mongator_logger',
            'collection' => 'Mongator_logger_grid.files',
            'gridfs'     => 1,
        ), $log), $this->log);
    }

    public function log(array $log)
    {
        $this->log = $log;
    }
}
