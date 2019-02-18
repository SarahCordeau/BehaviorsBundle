<?php

/**
 * This file is part of the ScoBehaviorsBundle package.
 *
 * (c) Sarah CORDEAU <cordeau.sarah@gmail.com>
 */

namespace Sco\BehaviorsBundle\Tests\Controller;

use Sco\BehaviorsBundle\Tests\Model\DummyObject;
use Sco\BehaviorsBundle\Controller\CommentController;
use Sco\BehaviorsBundle\Tests\Model\UserTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class CommentControllerTest extends WebTestCase
{
    /* @var $client \Symfony\Component\BrowserKit\Client $client */
    private $client;

    /** @var CommentController $controller */
    private $controller;

    /**
     * @inheritdoc
     */
    public function setUp(): void
    {
        $this->client = static::createClient();
        $container = $this->client->getContainer();
        $this->controller = new CommentController();
        $this->controller->setContainer($container);
        parent::setUp();
    }

    public function testRenderCommentFormWithoutObject()
    {
        /** @var Response $response */
        $response = $this->controller->formAction();

        $this->assertEquals(200, $response->getStatusCode(), "Unexpected status code.");
        $this->assertContains('Missing argument or null passed.', $response->getContent(), 'Content not valid');
    }

    public function testRenderCommentFormWithUser()
    {
        $this->logIn();

        $dummy = new DummyObject();

        $response = $this->controller->formAction($dummy);
        $this->assertEquals(200, $response->getStatusCode(), "Unexpected status code.");
        $this->assertContains('Enter your comment here.', $response->getContent(), 'Form not rendering.');
        $this->assertNotContains('Enter your username.', $response->getContent(), 'User not found.');
    }

    public function testRenderCommentFormWithAnonymousUser()
    {
        $this->logAsAnonymous();

        $dummy = new DummyObject();

        $response = $this->controller->formAction($dummy);
        $this->assertEquals(200, $response->getStatusCode(), "Unexpected status code.");
        $this->assertContains('Enter your comment here.', $response->getContent(), 'Form not rendering.');
        $this->assertContains('Enter your username.', $response->getContent(), 'User anonymous not found.');
    }

    public function testRenderCommentListWithNoResult()
    {
        $post = new DummyObject(1);

        $response = $this->controller->listAction($post);

        $this->assertEquals(200, $response->getStatusCode(), "Unexpected status code.");
        $this->assertNotContains('sco_behaviors_bundle__comment__list__children', $response->getContent(), 'List is not empty.');

    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = 'main';

        $user = (new UserTest())->setUsername('admin')->setPlainPassword('p@ssword');

        $token = new UsernamePasswordToken($user, null, $firewall, array('ROLE_ADMIN'));
        $this->client->getContainer()->get('security.token_storage')->setToken($token);

        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    private function logAsAnonymous()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context (defaults to the firewall name)
        $firewall = 'main';

        $token = new UsernamePasswordToken('anon.', null, $firewall, array());
        $this->client->getContainer()->get('security.token_storage')->setToken($token);

        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
