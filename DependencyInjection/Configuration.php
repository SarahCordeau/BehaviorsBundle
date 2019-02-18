<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Sco\BehaviorsBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder
            ->root('sco_behaviors_bundle')
            ->beforeNormalization()
            ->always(function(array $config) {
                if(empty($config)) {
                    return [
                        'commentable' => false,
                    ];
                }

                return $config;
            })
            ->end()
            ->children()
            ->booleanNode('commentable')->defaultFalse()->treatNullLike(false)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}