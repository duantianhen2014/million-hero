<?php

namespace Tests;

use App\Application;
use App\Foundation\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testRequest()
    {
        $this->assertInstanceOf(
            Request::class,
            Application::getInstance()->make('request')
        );
    }
}
