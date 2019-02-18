<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Comment
 * @package Sco\BehaviorsBundle\Entity
 */
class Comment
{
    use CommentProperties;
    use CommentMethods;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }
}