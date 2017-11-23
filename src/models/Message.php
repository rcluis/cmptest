<?php

namespace Cmptest\Models;

class Message
{
    protected $type;
    protected $text;

    /**
    * @param  string $text
    * @param  string $type
    */
    public function __construct($text, $type)
    {
        $this->text = $text;
        $this->type = $type;
    }

    /**
    * Returns if exists the given property
    *
    * @param  strting $property
    *
    * @return mixed
    */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
    * Sets if exists the given value to the property
    *
    * @param  string $property
    * @param  mixed  $value
    *
    * @return void
    */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }


    /**
    * Returns certain (for this test all) attributes in array format
    *
    * @param  string $property
    * @param  mixed  $value
    *
    * @return void
    */
    public function toArray()
    {
        return [
            'text' => $this->text,
            'type' => $this->type
        ];
    }
}
