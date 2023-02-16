<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepositories;

class PostRepository extends BaseRepositories implements PostRepositoryInterface
{
   // Lấy ra model tương ứng
   public function getModel()
   {
      return Post::class;
   }
}
