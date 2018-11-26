<?php
namespace phpunit\tests\unit;

class UserTest extends \PHPUnit\Framework\TestCase
{
    public function testCallMagicMethodWillSetAndGetUserProperties()
    { 
        $user = new \App\Models\User();
        $user->setFirstName('Nick');
        $this->assertEquals($user->getFirstName(), 'Nick');
        $user->setLastName('Roma');
        $this->assertEquals($user->getLastName(), 'Roma');  
    } 
}

