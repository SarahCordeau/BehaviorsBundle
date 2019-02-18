<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Entity;

/**
 * Trait CommentRecordProperties
 * @package Sco\BehaviorsBundle\Entity
 */
trait CommentRecordProperties
{
    /** @var int */
    protected $id;

    /**
     * @var string
     */
    protected $className;

    /**
     * @var integer
     */
    protected $objectId;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var Comment
     */
    protected $comment;
}