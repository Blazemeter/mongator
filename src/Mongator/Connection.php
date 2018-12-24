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

use MongoDB\Client as MongoDBClient;

/**
 * Connection.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 *
 * @api
 */
class Connection implements ConnectionInterface
{
    private $server;
    private $dbName;
    private $options;

    private $mongo;
    private $mongoDB;

    /**
     * Constructor.
     *
     * @param string $server  The server.
     * @param string $dbName  The database name.
     * @param array  $options The \MongoDB\Client options (optional).
     *
     * @api
     */
    public function __construct($server, $dbName, array $options = array())
    {
        $this->server = $server;
        $this->dbName = $dbName;
        $this->options = $options;
    }

    /**
     * Sets the server.
     *
     * @param string $server The server.
     *
     * @throws \LogicException If the mongo is initialized.
     *
     * @api
     */
    public function setServer($server)
    {
        if (null !== $this->mongo) {
            throw new \LogicException('The mongo is initialized.');
        }

        $this->server = $server;
    }

    /**
     * Returns the server.
     *
     * @return string $server The server.
     *
     * @api
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Sets the db name.
     *
     * @param string $dbName The db name.
     *
     * @throws \LogicException If the mongoDb is initialized.
     *
     * @api
     */
    public function setDbName($dbName)
    {
        if (null !== $this->mongoDB) {
            throw new \LogicException('The mongoDb is initialized.');
        }

        $this->dbName = $dbName;
    }

    /**
     * Returns the database name.
     *
     * @return string The database name.
     *
     * @api
     */
    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * Sets the options.
     *
     * @param array $options An array of options.
     *
     * @throws \LogicException If the mongo is initialized.
     *
     * @api
     */
    public function setOptions(array $options)
    {
        if (null !== $this->mongo) {
            throw new \LogicException('The mongo is initialized.');
        }

        $this->options = $options;
    }

    /**
     * Returns the options.
     *
     * @return array The options.
     *
     * @api
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getMongo()
    {
        if (null === $this->mongo) {
			$this->mongo = new MongoDBClient($this->server, $this->options);
        }

        return $this->mongo;
    }

    /**
     * {@inheritdoc}
     */
    public function getMongoDB()
    {
        if (null === $this->mongoDB) {
            $this->mongoDB = $this->getMongo()->selectDatabase($this->dbName);
        }

        return $this->mongoDB;
    }
}
