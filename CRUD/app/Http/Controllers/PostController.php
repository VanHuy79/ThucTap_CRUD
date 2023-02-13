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
        $post = Post::all()->sortByDesc("id");
        return view('post.index')->with(compact('post'));
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
        // checkFile
        $fileCheck = $request->hasFile('field_image');

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ];

        if ($fileCheck) {
            $file = $request->file('field_image');
            $postService = new PostService();
            $fieldImage = $postService->uploadFile($file);
            $data['field_image'] = $fieldImage;
        } else {
            return redirect('/blog/create')->with('error', "Vui lòng chọn File");
        }

        Post::create($data);

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
        // Kiểm tra file
        $fileCheck = $request->hasFile('field_image');

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->user()->id,
        ];

        if ($fileCheck) {
            $file = $request->file('field_image');
            $postService = new PostService();
            $fieldImage = $postService->uploadFile($file);
            $data['field_image'] = $fieldImage;
            // Xóa image cũ của bảng Image
            $post->image()->delete();
        }

        $post->update($data);

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
        if (!$posts) {
            return redirect()->back()->with('error', 'Không tìm thấy Post để xóa');
        }
        $image = File::where('image', $posts->field_image)->first();
        $image->delete();

        $posts->delete();
        \File::delete('images/' . $posts->image);

        return redirect('/blog')->with('notification', 'Xóa thành công');
    }
}
