<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\File;
use App\Services\Post\PostService;

class PostController extends Controller
{
    // protected $postService;
    // public function __construct(PostService $postService)
    // {
    //     $this->postService = $postService;
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post = Post::all()->sortByDesc("id");
        return view('post.index')
            ->with(compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PostService $postService)
    {
        $image = $postService->storeUploadFile($request);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image
        ];
        // dd($data);
        Post::create($data);
        return redirect('posts/')->with('notification', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return view('post.edit')->with(compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post, PostService $postService)
    {
        $image = $postService->updateUploadFile($request, $post);
        // Lấy ra name và description
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image
        ];
        
        // dd($data);
        $post->update($data);

        return redirect('posts/')->with('notification', 'Sửa mới thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // hàm xóa
        $post->delete();
        // Nếu xóa thì sẽ xóa luôn ảnh lưu trong foler
        \File::delete('images/' . $post->image);
        // quay trở lại trang chủ
        return redirect('posts/')->with('notification', 'Xóa thành công');
    }
}
