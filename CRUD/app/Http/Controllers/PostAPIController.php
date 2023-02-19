<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Post\PostService;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileAPIController;
use App\Http\Requests\PostRequest;

class PostAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all();
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Không có bài Post nào',
            ], 204);
        }
        return response()->json([
            'data' => $post,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $params = [
            'name' => $request->name,
            'description' => $request->description,
            'field_image' =>  $request->field_image,
            'user_id' => 1,
        ];
        $post = Post::create($params);

        return response()->json([
            'success' => true,
            'message' => 'Thêm mới thành công',
            'data' => $post
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
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bài Post nào',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'message' => $post,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy post cần cập nhật',
            ], 400);
        }
        $params = [
            'name' => $request->name,
            'description' => $request->description,
            'field_image' => $request->field_image,
            'user_id' => 1,
        ];
        // $post->image()->delete();
        // dd($params);
        $post->update($params);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công',
            'data' => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $posts = Post::find($id);
        if (!$posts) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy Post cần xóa',
            ], 400);
        } else {
            // $image = File::where('image', $posts->field_image)->first();
            // $image->delete();

            $posts->delete();
            // \File::delete('images/' . $posts->image);

            return response()->json([
                'success' => true,
                'message' => 'Xóa thành công',
                'data' => $posts,
            ], 204);
        }
    }
}
