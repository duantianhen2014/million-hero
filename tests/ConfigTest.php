<?php

namespace Tests;

use App\Application;
use App\Foundation\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testConfig()
    {
        $config = Application::getInstance()->make('config');

        $this->assertInstanceOf(
            Config::class,
            $config
        );

        return $config;
    }

    /**
     * @depends testConfig
     */
    public function testAipConfig(Config $config)
    {
        $this->assertNotNull($config->get('aip.APP_ID'));
        $this->assertNotNull($config->get('aip.API_KEY'));
        $this->assertNotNull($config->get('aip.SECRET_KEY'));
    }
}
