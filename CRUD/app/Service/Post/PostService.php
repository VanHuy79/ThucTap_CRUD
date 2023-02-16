<?php

namespace App\Service\Post;

use App\Repositories\Post\PostRepositoryInterface;

use App\Service\BaseService;
// Kế thừa các phương thức của Base
class PostService extends BaseService implements PostServiceInterface
{
   // Ghi đè lại phương thức repoc
   public $repository;
   // Truy vấn dữ liệu
   public function __construct(PostRepositoryInterface $postRepository)
   {
      $this->repository = $postRepository;
   }
}
