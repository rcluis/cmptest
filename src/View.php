<?php

namespace Cmptest;

use Psr\Http\Message\ResponseInterface;

class View extends \Slim\Views\PhpRenderer
{
    /**
    * @var string
    */
    protected $layout;

    /** @var array */
    protected $layoutData = array();

    /**
    * @param string $layout Pathname of layout script
    */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    // /**
    // * @param array $data
    // * @throws \InvalidArgumentException
    // */
    // public function setLayoutData($data)
    // {
    //     if (!is_array($data)) {
    //         throw new \InvalidArgumentException('Cannot append view data. Expected array argument.');
    //     }
    //
    //     $this->layoutData = $data;
    // }

    /**
    * @param array $data
    * @throws \InvalidArgumentException
    */
    public function appendLayoutData($data)
    {
        if (!is_array($data)) {
            throw new InvalidArgumentException('Cannot append view data. Expected array argument.');
        }

        $this->layoutData = array_merge($this->layoutData, $data);
    }

    /**
    * Render a template
    *
    * $data cannot contain template as a key
    *
    * throws RuntimeException if $templatePath . $template does not exist
    *
    * @param ResponseInterface $response
    * @param string             $template
    * @param array              $data
    *
    * @return ResponseInterface
    *
    * @throws \InvalidArgumentException
    * @throws \RuntimeException
    */
    public function render(ResponseInterface $response, $template, array $data = [])
    {
        if ($this->layout) {
            $content = parent::fetch($template, $data);
            $this->appendLayoutData(array('content' => $content));
            $this->data = $this->layoutData;

            $layout = $this->layout;
            $this->layout = null;
            return parent::render($response, $layout, $this->data);
        } else {
            return parent::render($response, $template, $data);
        }
    }
}
