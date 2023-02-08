<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\File;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allPosts = Post::paginate(15);
        // $postPagi = DB::table('post')->paginate(10);
        $post = Post::all()->sortByDesc("id");
        return view('post.index')
            ->with(compact('post'))
            ->with(compact('allPosts'));
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
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        // Ảnh
        if ($image = $request->file('image')) {
            // Đường dẫn lưu trữ
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $data['image'] = $profileImage;
            
        }
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
    public function update(Request $request, Post $post)
    {
        // Lấy ra name và description
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        if ($image = $request->file('image')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            // lấy ra thêm image
            $data['image'] = $profileImage;
            // Sẽ xóa ảnh cũ đi
            \File::delete('images/'. $post->image);
        } else {
            unset($profileImage);
        }
        dd($data);
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
        \File::delete('images/'. $post->image);
        // quay trở lại trang chủ
        return redirect('posts/')->with('notification', 'Xóa thành công');
    }
}
