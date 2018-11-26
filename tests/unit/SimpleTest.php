<?php
namespace phpunit\tests\unit;

class SimpleTest extends \PHPUnit\Framework\TestCase
{
    public function testReturnsTrue(): bool
    { 
        $this->assertTrue(TRUE);
        return true;
    }
}

