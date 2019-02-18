<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CommentRecordRepository
 * @package Sco\BehaviorsBundle\Repository
 */
class CommentRecordRepository extends EntityRepository
{
    /**
     * Return
     * array:1
     *      0 =>
     *          array:3
     *              'class_name' => string 'PostBundle\Entity\Blog'
     *              'class_total' => int 6
     *              'year' => string '2019'
     *
     * @param array $filter
     * @return array
     */
    public function fetchStatistics($filter = [])
    {
        if(array_key_exists('month', $filter)) {
            $func = 'MONTH';
            $order = $filter['month'];
        } else if(array_key_exists('year', $filter)) {
            $func = 'YEAR';
            $order = $filter['year'];
        } else {
            $func = 'YEAR';
            $order = 'desc';
        }

        $key = strtolower($func);

        $selection = "r.className AS class_name, COUNT(r.className) AS class_total, ";
        $selection .= "$func(r.createdAt) as ".$key;

        $qb = $this->createQueryBuilder('r');
        $qb
            ->select($selection)
            ->groupBy($key)
            ->addGroupBy('r.className')
            ->orderBy($key, $order)
        ;

        return $qb->getQuery()->getResult();
    }
}
