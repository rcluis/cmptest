<?php
namespace Cmptest\Controllers;

use Slim\Container as ContainerInterface;
use Cmptest\Models\Message;

class ChatController
{
    protected $container;
    const TABLE_MESSAGES = 'messages';

    /**
    * @param  ContainerInterface $container
    */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
    * Returns the chat view content
    *
    * @param  \Psr\Http\Message\ServerRequestInterface $req
    * @param  \Psr\Http\Message\ResponseInterface      $res
    * @param  array                                    $args
    *
    * @return \Psr\Http\Message\ResponseInterface
    */
    public function __invoke($request, $response, $args)
    {
        // Builds messages templates
        $messages = $this->container->get('dao')->selectAll(self::TABLE_MESSAGES);
        $messagesContainer = '';

        if(sizeof($messages) == 0)
        {
            // Sends and store a random message received
            $message = new Message('Hey, how are you?', 'received');
            $this->container->get('dao')->insert(self::TABLE_MESSAGES, $message);
            $messagesContainer .= $this->fetchMessage($message);
        }
        else {
            foreach ($messages as $message) {
                $messagesContainer .= $this->fetchMessage($message);
            }
        }

        $this->container->get('view')->setLayout('layout.phtml');
        $this->container->get('view')->appendLayoutData(['back' => true]);
        $this->container->get('view')->render($response, 'chat.phtml', ['messages' => $messagesContainer]);
    }

    /**
    * Sends a message either sent or received
    *
    * @param  \Psr\Http\Message\ServerRequestInterface $req
    * @param  \Psr\Http\Message\ResponseInterface      $res
    * @param  array                                    $args
    *
    * @return \Psr\Http\Message\ResponseInterface
    */
    public function sendMessage($request, $response, $args)
    {
        // Parse request body
        $requestBody = $request->getParsedBody();
        $text = $requestBody['text'];
        $type =  $requestBody['type'];

        // Create and save message
        $message = new Message($text, $type);
        $this->container->get('dao')->insert(self::TABLE_MESSAGES, $message);

        return $response->getBody()->write($this->fetchMessage($message));
    }

    /**
    * Returns the template of a given message
    *
    * @param Message $message
    * @return string
    */
    protected function fetchMessage(Message $message)
    {
        return $this->container->get('view')->fetch('message.phtml', $message->toArray());
    }
}
