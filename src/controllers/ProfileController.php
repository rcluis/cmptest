<?php
namespace Cmptest\Controllers;

use Slim\Container as ContainerInterface;

class ProfileController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
    * Returns the profile view content
    *
    * @param  \Psr\Http\Message\ServerRequestInterface $req
    * @param  \Psr\Http\Message\ResponseInterface      $res
    * @param  array                                    $args
    *
    * @return \Psr\Http\Message\ResponseInterface
    */
    public function __invoke($request, $response, $args)
    {
        $this->container->get('view')->setLayout('layout.phtml');
        $this->container->get('view')->render($response, "profile.phtml");
    }
}
