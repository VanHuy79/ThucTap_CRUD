<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\File;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use FilesystemIterator;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth', ['except' => ['index']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postImage = FIle::all();
        $post = Post::all()->sortByDesc("id");
        return view('post.index')
            ->with(compact('post'))
            ->with(compact('postImage'));
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
    public function store(Request $request)
    {
        $postService = new PostService();
        // Tách phần upload file sang một service khác
        $fieldImage = $postService->storeUploadFile($request->file('field_image'));
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
            'field_image' => $fieldImage
        ];
        // dd($data);
        $post = Post::create($data);
        // dd($post);
        return redirect('/blog')->with('notification', 'Thêm mới thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $user = Auth::user();
        $post = Post::find($id);
        return view('post.edit')
            ->with(compact('post'));
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
        $post = Post::findOrFail($id);
        // New PostService
        $postService = new PostService();
        $image = $postService->updateUploadFile($request->file('field_image'));
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
            'field_image' => $image
        ];
        // Khi update sẽ xóa pathFile cũ của bảng Image
        if ($image) {
            $post->image()->delete();
        }
        // Cập nhật mới
        $param = $post->update($data);
        // dd($param);

        return redirect('/blog')->with('notification', 'Sửa mới thành công');
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
        if ($posts) {
            $posts->image()->delete();
            $posts->delete();
        }

        \File::delete('images/' . $posts->image);
        // quay trở lại trang chủ
        return redirect('/blog')->with('notification', 'Xóa thành công');
    }
}
