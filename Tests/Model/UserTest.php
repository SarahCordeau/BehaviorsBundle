<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Tests\Model;

use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class UserTest
 * @package Sco\BehaviorsBundle\Tests\Model
 */
class UserTest extends BaseUser
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var string
     */
    private $name;

    public function __construct()
    {
        parent::__construct();

        $this->age = 0;
        $this->name = '';
        $this->setRoles(['ROLE_USER']);
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return $this
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}