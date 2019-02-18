<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Sco\BehaviorsBundle\DependencyInjection\BehaviorsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class BehaviorsExtensionTest extends TestCase
{
    public static function provideExtensions()
    {
        return array(
            array('commentable'),
        );
    }

    /**
     * @dataProvider provideExtensions
     */
    public function testLoadConfigWithCommentable($listener)
    {
        $extension = new BehaviorsExtension();
        $container = new ContainerBuilder();
        $config = array('commentable' =>true);
        $extension->load(array($config), $container);
        $this->assertTrue($container->hasDefinition(sprintf('sto.doctrine_behaviors.%s_subscriber', $listener)));
    }

    /**
     * @dataProvider provideExtensions
     */
    public function testLoadConfigWithoutCommentable($listener)
    {
        $extension = new BehaviorsExtension();
        $container = new ContainerBuilder();
        $config = array('commentable' =>false);
        $extension->load(array($config), $container);
        $this->assertFalse($container->hasDefinition(sprintf('sto.doctrine_behaviors.%s_subscriber', $listener)));
    }
}