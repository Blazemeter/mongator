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

use Mongator\Logger\Time;

class TimeTest extends \PHPUnit\Framework\TestCase
{
    public function testTime()
    {
        if (!class_exists('Mongator\Logger\Time')) {
            $this->markTestSkipped('Mongator\Logger\Time is not available.');
        }

        $time = new Time();
        $time->start();

        $this->assertTrue(is_int($time->stop()));
    }
}
