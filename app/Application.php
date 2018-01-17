<?php

namespace App;

use AipOcr;
use App\Foundation\Answer;
use App\Foundation\Command;
use App\Foundation\ReadImage;
use App\Foundation\ScreenShot;

class Application extends Container
{


    public function __construct($basePath = '')
    {
        $this->basePath = $basePath;

        $this->registerServices();
    }

    public function run()
    {

    }






}