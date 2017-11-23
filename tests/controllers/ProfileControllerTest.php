<?php

use PHPUnit\Framework\TestCase;
use Cmptest\App as App;
use Slim\Http\Environment;
use Slim\Http\Request;

class ProfileControllerTest extends TestCase
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
          'REQUEST_URI'    => '/wrongRoute',
          ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame($response->getStatusCode(), 404);
    }

    public function testInvoke()
    {
        $env = Environment::mock([
          'REQUEST_METHOD' => 'GET',
          'REQUEST_URI'    => '/',
          ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);

        $contentTemplate = $this->app->getContainer()->get('view')->fetch('profile.phtml');
        $bodyTemplate = $this->app->getContainer()->get('view')->fetch('layout.phtml', ['content' => $contentTemplate]);

        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame((string)$response->getBody(), $bodyTemplate);
    }

    public function testProfileHome()
    {
        $env = Environment::mock([
          'REQUEST_METHOD' => 'GET',
          'REQUEST_URI'    => '/profile',
          ]);
        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);

        $contentTemplate = $this->app->getContainer()->get('view')->fetch('profile.phtml');
        $bodyTemplate = $this->app->getContainer()->get('view')->fetch('layout.phtml', ['content' => $contentTemplate]);

        $this->assertSame($response->getStatusCode(), 200);
        $this->assertSame((string)$response->getBody(), $bodyTemplate);
    }
}
