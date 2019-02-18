<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserCallable
 * @package Sco\BehaviorsBundle\EventListener
 */
class UserCallable
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * UserCallable constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return object|string
     * @throws \Exception
     */
    public function __invoke()
    {
        $token = $this->container->get('security.token_storage')->getToken();
        if (null !== $token) {
            return $token->getUser();
        }
    }
}