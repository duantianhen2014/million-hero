<?php

/**
 * 中文分词
 */
function splitZh($string, $limit, $end) : string
{
    $string = preg_split('/(?<!^)(?!$)/u', $string);
    $array = array_chunk($string, $limit);

    // 链接
    $string = '';
    foreach ($array as $arr) {
        $string .= implode('', $arr) . $end;
    }
    $string = rtrim($string, $end);

    return $string;
}