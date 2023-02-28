<?php

namespace App\Service\Post;

use App\Service\ServiceInterface;

interface PostServiceInterface extends ServiceInterface
{
   public function getAll();
   public function createPost($request);
   public function showPost($id);
   public function updatePost($request, $id);
   public function deletePost($id);
}