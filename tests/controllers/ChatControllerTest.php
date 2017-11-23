<?php

use PHPUnit\Framework\TestCase;
use Cmptest\App as App;
use Slim\Http\Environment;
use Slim\Http\Request;
use Cmptest\Models\Message;

class ChatControllerTest extends TestCase
{
    protected $app;

    public function setUp()
    {
        @session_start();
        $this->app = (new App())->get();
    }

    public function testWrongRoute()
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/chat/wrongRoute',
        ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 404);
    }

    public function testInvokeWithoutRandomMessage()
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/chat',
        ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);

        $contentTemplate = $this->app->getContainer()->get('view')->fetch('chat.phtml');
        $bodyTemplate = $this->app->getContainer()->get('view')->fetch('layout.phtml', ['content' => $contentTemplate]);

        $this->assertSame($response->getStatusCode(), 200);
        $this->assertNotSame((string)$response->getBody(), $bodyTemplate);
    }

    public function testInvokeWithRandomMessage()
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/chat',
        ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);

        $message = new Message('Hey, how are you?', 'received');
        $messageTemplate = $this->app->getContainer()->get('view')->fetch('message.phtml', $message->toArray());
        $contentTemplate = $this->app->getContainer()->get('view')->fetch('chat.phtml', ['messages' => $messageTemplate]);
        $bodyTemplate = $this->app->getContainer()->get('view')->fetch('layout.phtml', ['content' => $contentTemplate, 'back' => true]);

        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame((string)$response->getBody(), $bodyTemplate);
    }

    public function testSendMessage()
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI'    => '/chat/message',
            'CONTENT_TYPE'   => 'multipart/form-data'
        ]);

        // Post params
        $_POST['text'] = 'text';
        $_POST['type'] = 'type';

        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);

        $message = new Message('text', 'type');
        $messageTemplate = $this->app->getContainer()->get('view')->fetch('message.phtml', $message->toArray());

        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame((string)$response->getBody(), $messageTemplate);
    }
}
