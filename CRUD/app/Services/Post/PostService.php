<?php

namespace App\Services\Post;

use File;
use App\Models\Post;
use Illuminate\Http\Request;

/**
 * Class PostService
 * @package App\Services
 */
class PostService
{
   // Thêm mới uploadFile
   public function storeUploadFile(Request $request)
   {
      if ($image = $request->file('image')) {
         $destinationPath = 'images/';
         $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
         $image->move($destinationPath, $profileImage);
         // lấy ra thêm image
         $data['image'] = $profileImage;
         return $profileImage;
      }
   }
   // Cập nhật mới uploadFile
   public function updateUploadFile(Request $request, Post $post)
   {
      if ($image = $request->file('image')) {
         $destinationPath = 'images/';
         $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
         $image->move($destinationPath, $profileImage);
         // lấy ra thêm image
         $data['image'] = $profileImage;
         // Sẽ xóa ảnh cũ đi
         File::delete('images/' . $post->image);
      } else {
         unset($profileImage);
      }
      return $profileImage;
   }
}
