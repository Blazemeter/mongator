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

use Mongator\Document\Document;

/**
 * The identity map class.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 *
 * @api
 */
class IdentityMap implements IdentityMapInterface
{
    private $documents;

    /**
     * Constructor.
     *
     * @api
     */
    public function __construct() {
        $this->documents = [];
    }

    /**
     * {@inheritdoc}
     */
    public function set($id, Document $document) {
        $this->documents[$this->serialize($id)] = $document;
    }

    /**
     * {@inheritdoc}
     */
    public function has($id) {
        return isset($this->documents[$this->serialize($id)]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id) {
        return $this->documents[$this->serialize($id)];
    }

    /**
     * {@inheritdoc}
     */
    public function all() {
        return $this->documents;
    }

    /**
     * {@inheritdoc}
     */
    public function &allByReference() {
        return $this->documents;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($id) {
        unset($this->documents[$this->serialize($id)]);
    }

    /**
     * {@inheritdoc}
     */
    public function clear() {
        $this->documents = [];
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function serialize($id) {
        if (is_array($id) || (is_object($id) && !($id instanceof \MongoId))) {
            $id = md5(serialize($id));
        }

        return (string) $id;
    }
}
