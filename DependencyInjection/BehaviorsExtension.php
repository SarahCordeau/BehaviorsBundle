<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class BehaviorsExtension
 * @package Sco\BehaviorsBundle\DependencyInjection
 */
class BehaviorsExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        foreach ($config as $behavior => $enabled) {
            if (!$enabled) {
                $container->removeDefinition(sprintf('sco.behaviors_bundle.%s_subscriber', $behavior));
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getAlias()
    {
        return 'sco_behaviors_bundle';
    }
}
