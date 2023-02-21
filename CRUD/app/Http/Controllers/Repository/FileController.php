<?php

namespace App\Http\Controllers\Repository;

use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use App\Http\Controllers\Controller;
use App\Imports\FileImport;
use Maatwebsite\Excel\Facades\Excel;
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
        $filename = 'data.csv';
        $filePath = public_path('excels/' . $filename);
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'Không tìm thấy csv'], 404);
        }
        $fileImport = new FileImport();
        $data = Excel::import($fileImport, $filePath);
        return response()->json([
            'success' => true,
            'message' => 'Thêm thành công',
            'data' => $data,
        ], 201);
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
