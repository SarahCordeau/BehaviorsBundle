<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle;

use Sco\BehaviorsBundle\DependencyInjection\BehaviorsExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ScoBehaviorsBundle
 * @package Sco\CommentableBundle
 */
class ScoBehaviorsBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new BehaviorsExtension();
    }
}
