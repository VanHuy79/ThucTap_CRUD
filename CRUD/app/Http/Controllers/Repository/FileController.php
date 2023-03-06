<?php

namespace App\Http\Controllers\Repository;


use App\Imports\FileImport;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Image;
use Illuminate\Support\Facades\Storage;
use App\Service\File\FileServiceInterface;

class FileController extends Controller
{
    private $fileService;
    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $file = $this->fileService->all();
        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'Không có dữ liệu',
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $file,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Upload lên Laravel s3
        // $filename = 'data.csv';
        // $filePath = public_path('excels/' . $filename);
        // if (!file_exists($filePath)) {
        //     return response()->json(['message' => 'Không tìm thấy csv'], 404);
        // }
        // $data = Excel::import(new FileImport(), $filePath);

        // // Upload file lên S3
        // Storage::disk('s3')->put($filename, file_get_contents($filePath));

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Thêm thành công',
        // ], 201);

        // Upload lên Laravel s3 Resize ảnh
        $data = $this->fileService->createFile();
        return $data;

        // Upload bằng đường dẫn trực tiếp
        // $url = 'https://cdn.topcv.vn/80/company_logos/cong-ty-tnhh-cybridge-a-chau-63f2df44341f3.jpg';
        // $fileContent = file_get_contents($url);
        // $fileName = basename($url);
        // $storage = Storage::disk('s3')->put('publics/' . $fileName, $fileContent);
        // $params = [
        // 'image' => $fileName,
        // 'user_id' => 1,
        // ];
        // $data = $this->fileService->create($params);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Thêm mới thành công',
        //     'data' => $data,
        // ], 201);

        // Cách upload API
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        //     $fileName = $file->getClientOriginalName();
        //     $file->move(public_path('images/'), $fileName);
        //     $params = [
        //         'image' => $fileName,
        //         'user_id' => 1,
        //         // 'field_image' => $fileName,
        //     ];

        //     $file = $this->fileService->create($params);

        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Thêm mới thành công',
        //         'data' => $fileName,
        //     ], 201);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = $this->fileService->find($id);
        if ($file) {
            return response()->json([
                'success' => true,
                'data' => $file,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy File cần tìm'
        ], 400);
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FileRequest $request, $id)
    {
        if ($request->hasFile('field_image')) {
            $file = $request->file('field_image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('images/'), $fileName);
            $params = [
                'image' => $fileName,
                'user_id' => 1,
            ];

            $file = $this->fileService->update($params, $id);
            if ($file) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật thành công',
                    'data' => $fileName
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy File ảnh cần cập nhật',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = $this->fileService->delete($id);
        if ($file) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công',
                'data' => $file,
            ], 204);
        }
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy File ảnh cần xóa',
        ], 400);
    }
}