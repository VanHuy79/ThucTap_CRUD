<?php

namespace App\Services\Post;

use App\Models\File;
use App\Models\Post;
use Illuminate\Http\Request;
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
      $fileName = $files->getClientOriginalName();
      $files->move(public_path('images/'), $fileName);
      $data['field_image'] = $fileName;
      File::create([
         'image' => $fileName,
         'user_id' => auth()->user()->id
      ]);
      return $fileName;
   }
   // Cập nhật mới uploadFile
   public function updateUploadFile($files)
   {
      if ($files) {
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
}
