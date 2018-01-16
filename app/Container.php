<?php

namespace App;


use AipOcr;

class Container
{
    public static $instance;

    protected $basePath;

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }


    protected function registerServices()
    {
        static::$instance = $this;
    }


    public function getBasePath()
    {
        return $this->basePath;
    }
}