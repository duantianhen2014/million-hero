<?php

namespace App\Foundation;


class Image
{
    protected $dst;
    protected $src;
    protected $path;


    public function cut($path, $width = 520)
    {
        $this->src = imagecreatefrompng($this->path = $path);

        $x = imagesx($this->src);
        $y = imagesy($this->src);

        $height = $y/$x*$width;
        $this->dst = imagecreatetruecolor($width, $height);
        // 百万英雄，截图大小 70, 300, $w-100,900
        if ($y > 900) {
            $y = 900;
        }

        // 只要答案的区域
        imagecopyresized($this->dst, $this->src, 0, 0, 70, 300, $width, $height, $x-100, $y);

        return $this;
    }

    public function save($path = null)
    {
        imagedestroy($this->src);

        if (! is_null($path)) {
            $this->path = $this->path;
        }

        imagepng($this->dst, $this->path);
        imagedestroy($this->dst);
    }
}