<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * Class CommentableSubscriber
 * @package Sco\BehaviorsBundle\EventListener
 */
class CommentableSubscriber implements EventSubscriber
{
    /** @var mixed */
    private $user;

    /** @var callable */
    private $userCallable;

    /** @var mixed */
    private $userEntity;

    /**
     * CommentableSubscriber constructor.
     * @param callable|null $userCallable
     * @param null $userEntity
     */
    public function __construct(
        callable $userCallable = null,
        $userEntity = null
    )
    {
        $this->userCallable = $userCallable;
        $this->userEntity = $userEntity;
    }

    /**
     * @param $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Return the user representation
     */
    public function getUser()
    {
        if (null !== $this->user) {
            return $this->user;
        }
        if (null === $this->userCallable) {
            return;
        }

        $callable = $this->userCallable;

        return $callable();
    }

    /**
     * @return array|string[]
     */
    public function getSubscribedEvents()
    {
        $events = [
            Events::prePersist,
        ];

        return $events;
    }

    /**
     * @param callable $callable
     */
    public function setUserCallable(callable $callable)
    {
        $this->userCallable = $callable;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();

        if (property_exists($entity, 'createdBy') && !$entity->getCreatedBy()) {
            $user = $this->getUser();

            if ($this->isValidUser($user)) {
                $entity->setCreatedBy($user);
            }
        }

        if(property_exists($entity, 'createdAt') && !$entity->getCreatedAt()) {
            $entity->setCreatedAt(new \DateTime());
        }
    }

    /**
     * @param $user
     * @return bool
     */
    private function isValidUser($user)
    {
        if ($this->userEntity) {
            return $user instanceof $this->userEntity;
        }

        if (is_object($user)) {
            return method_exists($user, '__toString');
        }

        return is_string($user);
    }
}