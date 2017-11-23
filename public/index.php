<?php
require '../vendor/autoload.php';
use Cmptest\App;

$app = (new App())->get();

// $app->get('/', function (Request $request, Response $response) {
//     // $name = $request->getAttribute('name');
//     // $response->getBody()->write("Hello, $name");
//
//     $response = $this->view->render($response, "profile.phtml");
//     return $response;
// });
$app->run();
