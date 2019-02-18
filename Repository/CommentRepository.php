<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CommentRepository
 * @package Sco\BehaviorsBundle\Repository
 */
class CommentRepository extends EntityRepository
{
    /**
     * @param $object
     * @return array
     */
    public function fetchComments($object)
    {
        if(!is_callable([get_class($object), 'getId'])) {
            return [];
        }

        $qb = $this->createQueryBuilder('c')
            ->innerJoin('c.commentRecord', 'r')
            ->where('r.objectId = :id')
            ->andWhere('r.className = :name')
            ->andWhere('c.parent is null')
            ->setParameters([
                'id' => $object->getId(),
                'name' => get_class($object)
            ])
            ->orderBy('r.createdAt', 'DESC')
            ->addOrderBy('r.className', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }
}