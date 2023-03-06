<?php

namespace App\Service\Post;

use App\Service\BaseService;

use Illuminate\Support\Facades\Auth;
use App\Repositories\Post\PostRepositoryInterface;

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
   public function getAll()
   {
      $data = $this->repository->all();

      return response()->json([
         'success' => true,
         'message' => 'List danh sách Post',
         'data' => $data,
      ]);
   }

   public function createPost($request)
   {
      $params = [
         'name' => $request->name,
         'description' => $request->description,
         'field_image' => $request->field_image,
         'user_id' => 22,
      ];

      $data = $this->repository->create($params);

      if ($data) {
         return response()->json([
            'success' => true,
            'message' => 'Thêm thành công',
            'data' => $data,
         ]);
      }
      return response()->json([
         'success' => false,
         'message' => 'Thêm không thành công',
      ]);
   }

   public function showPost($id)
   {
      $data = $this->repository->find($id);

      if ($data) {
         return response()->json([
            'success' => true,
            'data' => $data
         ]);
      }
      return response()->json([
         'success' => false,
         'message' => 'Không tìm thấy Post cần tìm',
      ]);
   }

   public function updatePost($request, $id)
   {
      $params = [
         'name' => $request->name,
         'description' => $request->description,
         'field_image' => $request->field_image,
         'user_id' => 1,
      ];

      $data = $this->repository->update($params, $id);

      if ($data) {
         return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công',
            'data' => $data,
         ]);
      }
      return response()->json([
         'success' => false,
         'message' => 'Không tìm thấy Post cần cập nhật',
      ]);
   }

   public function deletePost($id)
   {
      $data = $this->repository->delete($id);

      if ($data) {
         return response()->json([
            'success' => true,
            'message' => 'Xóa thành công',
         ]);
      }
      return response()->json([
         'success' => false,
         'message' => 'Không tìm thấy Post cần xóa',
      ]);
   }
}
