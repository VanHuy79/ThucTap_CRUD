<?php

namespace App\Services\Post;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
// use Faker\Provider\File;

/**
 * Class PostService
 * @package App\Services
 */
class PostService
{
   // Thêm mới uploadFile
   public function storeUploadFile($files)
   {
      if (!empty($files)) {
         $fileName = $files->getClientOriginalName();
         $files->move(public_path('images/'), $fileName);
         $data['field_image'] = $fileName;
         File::create([
            'image' => $fileName,
            'user_id' => auth()->user()->id
         ]);
      }
      return $fileName;
   }
   // Cập nhật mới uploadFile
   public function updateUploadFile($files)
   {
      if (!empty($files)) {
         $fileName = $files->getClientOriginalName();
         $files->move(public_path('images/'), $fileName);
         // lấy ra thêm image
         $data['field_image'] =  $fileName;
         File::updateOrCreate([
            'image' =>  $fileName,
            'user_id' => auth()->user()->id,
         ]);
      } else {
         unset($fileName);
      }
      return  $fileName;
   }

   // Viết chung 1 hàm store và update của File
   public function uploadFile($file)
   {
      if (!empty($file)) {
         $fileName = $file->getClientOriginalName();
         $file->move(public_path('images/'), $fileName);
         // File::create([
         //    'image' =>  $fileName,
         //    'user_id' => 1,
         // ]);
      }
      return $fileName;
   }
}
