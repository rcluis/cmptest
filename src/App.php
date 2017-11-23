<?php

namespace Cmptest;

use Slim\App as SlimApp;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Cmptest\Controllers\ProfileController;
use Cmptest\Controllers\ChatController;
use Cmptest\View;
use Cmptest\DAO;

class App
{
    /**
    * Instance of the Slim app
    *
    * @var \Slim\App
    */
    private $app;

    public function __construct()
    {
        $config = $config = [
            'settings' => [
                'displayErrorDetails' => true,
            ]
        ];

        $app = new SlimApp($config);

        $container = $app->getContainer();
        $container['view'] = new View(__DIR__.'/../resources/templates/');
        $container['dao'] = new DAO();

        // Routes
        $app->get('/', ProfileController::class);
        $app->get('/profile', ProfileController::class);
        $app->group('/chat', function() {
            $this->get('', ChatController::class);
            $this->post('/message', ChatController::class . ':sendMessage');
        });
        $app->get('/clearSession', function(Request $request, Response $response) {
            return $response->getBody()->write($this->dao->close());
        });

        $this->app = $app;
    }

    /**
    * Get an instance of the application.
    *
    * @return SlimApp
    */
    public function get()
    {
        return $this->app;
    }
}
