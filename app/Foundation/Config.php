<?php

namespace App\Foundation;


class Config
{
    protected $config = [];
    protected $files = ['aip', 'cache', 'app'];

    public function __construct($configPath)
    {
        foreach ($this->files as $file) {
            $this->config[$file] = require "{$configPath}/{$file}.php";
        }
    }

    public function get($key, $default = null)
    {
        list($file, $key) = explode('.', $key);

        return $this->config[$file][$key];
    }
}