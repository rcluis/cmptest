<?php

use PHPUnit\Framework\TestCase;
use Cmptest\App as App;
use Slim\Http\Environment;
use Slim\Http\Request;

class CommonTest extends TestCase
{
    protected $app;

    public function setUp()
    {
        @session_start();
        $this->app = (new App())->get();
    }

    public function testClearSession()
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/clearSession',
        ]);

        $req = Request::createFromEnvironment($env);
        $this->app->getContainer()['request'] = $req;
        $response = $this->app->run(true);
        $this->assertSame((string)$response->getBody(), '1');
    }
}
