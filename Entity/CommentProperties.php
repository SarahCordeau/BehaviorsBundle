<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait CommentProperties
 * @package Sco\BehaviorsBundle\Entity
 */
trait CommentProperties
{
    /** @var int */
    protected $id;

    /** @var mixed */
    protected $createdBy;

    /** @var \DateTime */
    protected $createdAt;

    /** @var string */
    protected $content;

    /** @var CommentRecord */
    private $commentRecord;

    /** @var ArrayCollection */
    private $children;

    /** @var Comment */
    private $parent;
}