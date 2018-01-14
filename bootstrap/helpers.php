<?php

if (! function_exists('env')) {
    function env($key, $default)
    {
        $value = getenv($key);

        if ($value === false) {
            $value = $default;
        }

        return $value;
    }
}

if (! function_exists('dd')) {
    function dd($output)
    {
        if (is_string($output)) {
            echo $output;
        } elseif (is_array($output) || is_object($output)) {
            print $output;
        } else {
            var_dump($output);
        }

        exit;
    }
}