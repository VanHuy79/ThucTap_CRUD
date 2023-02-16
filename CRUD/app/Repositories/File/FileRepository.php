<?php

namespace App\Repositories\File;

use App\Models\File;
use App\Repositories\BaseRepositories;

class FileRepository extends BaseRepositories implements FileRepositoryInterface
{
   public function getModel()
   {
      return File::class;
   }
}
