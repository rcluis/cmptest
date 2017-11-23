<?php

use PHPUnit\Framework\TestCase;
use Cmptest\Models\Message;

class MessageTest extends TestCase
{
    public function testNotExistAttribute()
    {
         $this->assertClassNotHasAttribute('foo', Message::class);
    }

    public function testExistsTypeAttribute()
    {
        $this->assertClassHasAttribute('type', Message::class);
    }

    public function testExistsTextAttribute()
    {
        $this->assertClassHasAttribute('text', Message::class);
    }

    public function testGetter()
    {
        $message = new Message('text', 'type');

        $this->assertSame($message->__get('text'), 'text');
        $this->assertSame($message->__get('type'), 'type');
    }

    public function testSetter()
    {
        $message = new Message('text', 'type');

        $message->__set('text', 'foo');

        $this->assertNotSame($message->__get('text'), 'text');
        $this->assertSame($message->__get('type'), 'type');
    }

    public function testToArray()
    {
        $message = new Message('text', 'type');
        $arrayMessage = $message->toArray();

        $this->assertArrayHasKey('text', $arrayMessage);
        $this->assertArrayHasKey('type', $arrayMessage);
        $this->assertSame($arrayMessage, [
            'text' => 'text',
            'type' => 'type'
        ]);
    }
}
