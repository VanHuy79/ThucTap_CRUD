<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\Post\PostService;

class FileAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $file = File::all();
        return response()->json([
            'file' => $file
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request)
    {
        if ($request->hasFile('filed_image')) {
            $file = $request->file('filed_image');
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('images/'), $fileName);
            $params = [
                'image' => $fileName,
                'user_id' => 1,
                // 'field_image' => $fileName,
            ];
            $file = File::create($params);

            return response()->json([
                'success' => true,
                'message' => 'Thêm mới thành công',
                'data' => $fileName
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::find($id);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy ảnh nào',
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $file,
        ]);
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
        $fileID = File::find($id);
        if (!$fileID) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy File để cập nhật',
            ]);
        } else {
            if ($request->hasFile('field_image')) {
                $file = $request->file('field_image');
                $fileName = $file->getClientOriginalName();
                $file->move(public_path('images/'), $fileName);
                $params = [
                    'image' => $fileName,
                    'user_id' => 1,
                ];
                $file = File::updateOrCreate($params);

                return response()->json([
                    'success' => true,
                    'message' => 'Cập nhật thành công',
                    'data' => $fileName
                ], 200);
            }
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
        $file = File::find($id);
        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy File cần xóa'
            ]);
        }
        $file->delete();
        return response()->json([
            'success' => true,
            'message' => 'Xóa thành công',
        ]);
    }
}
