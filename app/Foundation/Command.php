<?php

namespace App\Foundation;


class Command
{
    public static function shellExec($shell)
    {
        return shell_exec($shell);
    }

    public static function exactExec($shell)
    {
        exec($shell, $output, $code);

        // 删除空数组
        $output = array_filter($output);

        return [$code, $output];
    }
}