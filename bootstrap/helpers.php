<?php

if (! function_exists('env')) {
    function env($key, $default = null)
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
        } else {
            var_dump($output);
        }

        exit;
    }
}

if (! function_exists('cachePath')) {
    function cachePath($file = null)
    {
        $basePath = \App\Application::getInstance()->getBasePath();
        $basePath = trim($basePath, '/\\');
        $cachePath = "{$basePath}/bootstrap/cache/";

        if (! is_null($file)) {
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
            $cachePath .= "{$file}";
        }

        return $cachePath;
    }
}