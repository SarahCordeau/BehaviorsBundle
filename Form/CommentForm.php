<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Form;

use Sco\BehaviorsBundle\Entity\Comment;
use Sco\BehaviorsBundle\Form\Type\ContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class CommentForm
 * @package Sco\BehaviorsBundle\Form
 */
class CommentForm extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token->getToken();
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $record = $options['comment_record'];

        $builder
            ->add('content', ContentType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'sco_behaviors_bundle__comment__form__content',
                    'placeholder' => 'Enter your comment here.',
                ],
                'required' => true,
            ])
            ->add('commentRecord', HiddenType::class, [
                'property_path' => 'commentRecord.className',
                'data' => $record->getClassName(),
                'attr' => ['class' => 'sco_behaviors_bundle__comment__form__comment_record'],
            ]);

        if (!\is_object($user = $this->token->getUser())) {
            // e.g. anonymous authentication
            $builder
                ->add('createdBy', TextType::class, [
                    'label' => false,
                    'attr' => [
                        'class' => 'sco_behaviors_bundle__comment__form__created_by',
                        'placeholder' => 'Enter your username.'
                    ],
                    'required' => true,
                ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
            'comment_record' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sco_behaviors_bundle_comment_form';
    }
}