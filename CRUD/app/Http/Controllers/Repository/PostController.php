<?php

namespace App\Http\Controllers\Repository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
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
     * @bodyParam name string required Tên của bài Post.
     * @bodyParam description required Mô tả của bài Post.
     * @bodyParam field_image required Ảnh của bài Post.
     * @bodyParam user_id integer required ID của người dùng tạo ra bài viết.
     * @response 200 {
     *   "success": true
     *   "data": {
     *      "id": 195,
     *      "name": "bài 2",
     *      "description": "bài 2"
     *      "field_image": "anh2.jpg",
     *      "user_id": 1,
     *      "created_at": "2023-02-16 07:47:36",
     *      "updated_at": "2023-02-16 07:53:31",
     *    }
     * }
     * @response 500 {
     *   "success": false
     *   "message": "Internal Server Error."
     * }
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
     * This will be in the "Servers" subgroup of "Resource management"
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * @bodyParam name string required Tên của bài Post.
     * @bodyParam description required Mô tả của bài Post.
     * @bodyParam field_image required Ảnh của bài Post.
     * @bodyParam user_id integer required ID của người dùng tạo ra bài viết.
     * @response 201{
     * "success": true
     * "data": {
     *      "id": 202,
     *      "name": "Post Test",
     *      "description": "bài 2"
     *      "field_image": "anh3.png",
     *      "user_id": 1,
     *      "created_at": "2023-02-16 07:47:36",
     *      "updated_at": "2023-02-16 07:47:36",
     *  }
     *  "message": "Thêm mới thành công"
     * },
     * @response 401 {
     *   "success": false
     *   "message": "Unauthenticated."
     * }
     * @response 403 {
     *   "success": false
     *   "message": "This action is unauthorized."
     * }
     * @response 500 {
     *   "success": false
     *   "message": "Internal Server Error."
     * }
     */
    public function store(PostRequest $request)
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
     * @response 200 {
     *     "success": true
     *     "data": {
     *          "id": 202,
     *          "name": "Post Test",
     *          "description": "Post Test"
     *          "filed_image": "anh3.png",
     *          "user_id": 1,
     *          "created_at": "2023-02-16 07:47:36",
     *          "updated_at": "2023-02-16 07:47:36",
     *      }
     * },
     * @response 400 {
     *      "success": false
     *      "message": "Không tìm thấy Post cần tìm"
     * }
     * @response 401 {
     *   "success": false
     *   "message": "Unauthenticated."
     * }
     * @response 403 {
     *   "success": false
     *   "message": "This action is unauthorized."
     * }
     * @response 500 {
     *   "success": false
     *   "message": "Internal Server Error."
     * }
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
     * @bodyParam name string required Tên của bài Post.
     * @bodyParam description required Mô tả của bài Post.
     * @bodyParam field_image file required Ảnh của bài Post.
     * @bodyParam user_id integer required ID của người dùng tạo ra bài viết.
     * @response 200 {
     * "success": true
     * "data": {
     *      "id": 202,
     *      "name": "Post Cập Nhật",
     *      "description": "Post Cập Nhật"
     *      "field_image": "anh2.jpg",
     *      "user_id": 2,
     *      "created_at": "2023-02-16 07:47:36",
     *      "updated_at": "2023-02-16 07:47:36",
     *  }
     * "message": "Cập nhật thành công"
     * },
     * @response 400 {
     *      "success": false
     *      "message": "Không tìm thấy Post cần tìm"
     * }
     * @response 401 {
     *   "success": false
     *   "message": "Unauthenticated."
     * }
     * @response 403 {
     *   "success": false
     *   "message": "This action is unauthorized."
     * }
     * @response 500 {
     *   "success": false
     *   "message": "Internal Server Error."
     * }
     */
    public function update(PostRequest $request, $id)
    {
        $params = [
            'name' => $request->name,
            'description' => $request->description,
            'field_image' =>  $request->field_image,
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
     * @response 204 {
     *   "success": true
     *   "message": "Xóa thành công"
     * }
     * @response 400 {
     *      "success": false
     *      "message": "Không tìm thấy Post cần xóa"
     * }
     * @response 500 {
     *   "success": false
     *   "message": "Internal Server Error."
     * }
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
