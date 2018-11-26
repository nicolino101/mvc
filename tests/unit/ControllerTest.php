<?php
namespace phpunit\tests\unit;

use App\Controllers\Index;

class ControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testCanLoadIndexController()
    { 
        $controller = new Index();
        //$_GET['test'] = 'test';
       // $index = $controller->index();
        //$this->assertEquals(['test' => 'test']);  
        $user = $controller->user(['firstName' => "Nick", 'lastName' => 'Roma', 'email' => 'test@test.com']);
        $this->assertInstanceOf('\App\Models\User', $user);  
    } 
}

