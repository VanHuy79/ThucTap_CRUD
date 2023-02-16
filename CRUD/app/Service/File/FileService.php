<?php

namespace App\Service\File;

use App\Repositories\File\FileRepositoryInterface;

use App\Service\BaseService;

class FileService extends BaseService implements FileServiceInterface
{
   public $repository;

   public function __construct(FileRepositoryInterface $fileRepository)
   {
      $this->repository = $fileRepository;
   }
}
