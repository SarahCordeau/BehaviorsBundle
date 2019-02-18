<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Trait CommentMethods
 * @package Sco\BehaviorsBundle\Entity
 */
trait CommentMethods
{
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
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     * @return $this
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return CommentRecord
     */
    public function getCommentRecord()
    {
        return $this->commentRecord;
    }

    /**
     * @param CommentRecord $commentRecord
     * @return $this
     */
    public function setCommentRecord(CommentRecord $commentRecord)
    {
        $commentRecord->setComment($this);
        $this->commentRecord = $commentRecord;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addChildren(Comment $comment)
    {
        $this->children[] = $comment;
        $comment->setParent($this);

        return $this;
    }

    /**
     * @return Comment|null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function setParent(Comment $comment)
    {
        $this->parent = $comment;

        return $this;
    }

    /**
     * @param Comment $child
     * @param int $count
     * @return int
     */
    public function countParent(Comment &$child, $count = 0)
    {
        if(null !== $parent = $child->getParent()) {
            $count++;
            $count = $this->countParent($parent, $count);
        }

        return $count;
    }
}