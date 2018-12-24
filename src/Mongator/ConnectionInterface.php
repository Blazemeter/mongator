<?php

/*
 * This file is part of Mongator.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mongator;
use MongoDB\Client;

/**
 * ConnectionInterface.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 *
 * @api
 */
interface ConnectionInterface
{
    /**
     * Returns the mongo connection object.
     *
     * @return \MongoDB\Client The mongo collection object.
     *
     * @api
     */
    public function getMongo();

    /**
     * Returns the database object.
     *
     * @return \MongoDB\Database The database object.
     *
     * @api
     */
    public function getMongoDB();
}
