<?php

namespace App\Service\File;

use App\Imports\FileImport;

use App\Service\BaseService;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Repositories\File\FileRepositoryInterface;

class FileService extends BaseService implements FileServiceInterface
{
   public $repository;

   public function __construct(FileRepositoryInterface $fileRepository)
   {
      $this->repository = $fileRepository;
   }

   public function createFile()
   {
      $filename = 'data.csv';
      $filePath = public_path('excels/' . $filename);
      if (!file_exists($filePath)) {
         return response()->json(['message' => 'Không tìm thấy csv'], 404);
      }
      $data = Excel::import(new FileImport(), $filePath);
      // $imageContent = file_get_contents($filePath);

      // $image = Image::make($imageContent);

      // // rộng cao 350
      // $image->resize(350, 350, function ($constraint) {
      //    $constraint->aspectRatio();
      // });

      // $imageContent = $image->encode('jpg', 50);
      // Upload file ảnh đã resize lên S3
      Storage::disk('s3')->put($filename, file_get_contents($filePath));

      return response()->json([
         'success' => true,
         'message' => 'Thêm thành công',
      ], 201);
   }
}