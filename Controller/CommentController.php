<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Controller;

use Sco\BehaviorsBundle\Entity\Comment;
use Sco\BehaviorsBundle\Entity\CommentRecord;
use Sco\BehaviorsBundle\Form\CommentForm;
use Sco\BehaviorsBundle\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CommentController
 * @package Sco\BehaviorsBundle\Controller
 */
class CommentController extends Controller
{
    /**
     * Render form to create a new entity Comment.
     *
     * @param $object
     * @param null $parentId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction($object = null, $parentId = null)
    {
        if(empty($object)) {
            return $this->render('@ScoBehaviorsBundle/error.html.twig', ['message' => 'Missing argument or null passed.']);
        }

        if(!is_callable([get_class($object), 'getId'])) {
            return $this->render('@ScoBehaviors/error.html.twig', ['message' => 'The method getId is not callable.']);
        }

        /** @var CommentRecord $record */
        $record =(new CommentRecord())
            ->setObjectId($object->getId())
            ->setClassName(get_class($object));

        /** @var Comment $comment */
        $comment = (new Comment())->setCommentRecord($record);

        $form = $this->createForm(CommentForm::class, $comment, [
            'action' => $this->generateUrl('sco_behaviors_bundle_comments_new', ['object_id' => $object->getId(), 'parent_id' => $parentId]),
            'comment_record' => $record,
        ]);

        return $this->render('@ScoBehaviors/comment/form.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Create a new Entity Comment.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newAction(Request $request): Response
    {
        $data = $request->get('sco_behaviors_bundle_comment_form');

        if(empty($data) || empty($request->get('object_id'))) {
            return $this->render('@ScoBehaviors/error.html.twig', ['message' => 'Missing argument or null passed.']);
        }

        $objectId = $request->get('object_id');
        $parentId = $request->get('parent_id');

        /** @var CommentRecord $record */
        $record =(new CommentRecord())
            ->setObjectId($objectId)
            ->setClassName($data['commentRecord']);

        /** @var Comment $comment */
        $comment = (new Comment())->setCommentRecord($record);

        $form = $this->createForm(CommentForm::class, $comment, [
            'action' => $this->generateUrl('sco_behaviors_bundle_comments_new', ['object_id' => $objectId, 'parent_id' => $parentId]),
            'comment_record' => $record,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);

            if(null !== $parentId) {
                $parent = $em->getRepository(Comment::class)->find($parentId);
                $parent->addChildren($comment);
            }

            $em->flush();

            $referer = $request->headers->get('referer');

            return $this->redirect($referer);
        }

        return $this->render('@ScoBehaviors/comment/form.html.twig', array(
            'request' => $request,
            'comment' => $comment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Return list of comment for the object passed it parameter.
     *
     * @param $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction($object = null): Response
    {
        if(empty($object)) {
            return $this->render('@Commentable/error.html.twig', ['message' => 'Missing argument or null passed.']);
        }

        /** @var CommentRepository $repository */
        $repository = $this->getDoctrine()->getManager()->getRepository(Comment::class);

        $comments = $repository->fetchComments($object);

        return $this->render('@ScoBehaviors/comment/list.html.twig', [
            'comments' => $comments,
            'object' => $object,
            'limit' => $this->getParameter('sco.behaviors_bundle.reply_limit', 1)
        ]);
    }

    /**
     * Return statistic by year and class_name ordering by year desc like
     * array:2 [▼
     *      2018 => array:1 [▼
     *          0 => array:3 [▼
     *              "class_name" => "PostBundle\Entity\Post"
     *              "class_total" => 1
     *              "year" => "2018"
     *          ]
     *      ]
     *      2017 => array:1 [▼
     *          0 => array:3 [▼
     *              "class_name" => "PostBundle\Entity\Post"
     *              "class_total" => 2
     *              "year" => "2017"
     *          ]
     *      ]
     *   ]
     *
     * @param string $filter
     * @param string $order
     * @return Response
     */
    public function statisticAction($filter, $order): Response
    {
        $search[$filter] = $order;

        /** @var array $result */
        $result = $this->getDoctrine()->getRepository(CommentRecord::class)->fetchStatistics($search);

        /**
         * Fetch result to display statistics
         */
        $stats = [];
        $key = strtolower($filter);

        foreach ($result as $r) {
            if(!array_key_exists($r[$key], $stats)) {
                $stats[$r[$key]][] = $r;
                continue;
            }

            $stats[$r[$key]][] = $r;
        }

        return $this->render('@ScoBehaviors/comment/statistic.html.twig', [
            'func' => $key,
            'stats' => $stats,
        ]);
    }
}
