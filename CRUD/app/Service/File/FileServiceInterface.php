<?php

namespace App\Service\File;

use App\Service\ServiceInterface;

interface FileServiceInterface extends ServiceInterface
{
    public function createFile();
}
