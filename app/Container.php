<?php

namespace App;


use Closure;

class Container
{
    protected static $instance;
    protected $binds = [];
    protected $instances = [];


    public function bind($name, $abstract)
    {
        $this->binds[$name] = $abstract;
    }

    public function make($name)
    {
        if (! isset($this->instances[$name])) {
            $this->instances[$name] = $this->resolve($name);
        }

        return $this->instances[$name];
    }

    protected function resolve($name)
    {
        $abstract = $this->binds[$name];

        if ($abstract instanceof Closure) {
            $instance = call_user_func($abstract);
        } else {
            $instance = new $abstract;
        }

        return $instance;
    }


    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}