<?php

namespace App\Http\Controllers\Repository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service\Post\PostServiceInterface;

class PostController extends Controller
{
    private $postService;
    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = $this->postService->all();

        return response()->json([
            'success' => true,
            'data' => $post,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = [
            'name' => $request->name,
            'description' => $request->description,
            'field_image' =>  $request->field_image,
            'user_id' => 1,
        ];

        $post = $this->postService->create($params);
        return response()->json([
            'success' => true,
            'message' => 'Thêm thành công',
            'data' => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = $this->postService->find($id);

        if ($post) {
            return response()->json([
                'success' => true,
                'data' => $post,
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy dữ liệu',
        ], 400);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $params = [
            'name' => $request->name,
            'description' => $request->description,
            'field_image' => $request->field_image,
            'user_id' => 1,
        ];
        $post = $this->postService->update($params, $id);
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công',
                'data' => $post
            ], 200);
        }
        return response()->json([ 
            'success' => false,
            'message' => 'Không tìm thấy Post cần cập nhật'
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = $this->postService->delete($id);
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công',
                'data' => $post,
            ], 204);
        }
        return response()->json([
            'success' => false,
            'message' => ' Không tìm thấy Post để xóa',
        ], 400);
    }
}
