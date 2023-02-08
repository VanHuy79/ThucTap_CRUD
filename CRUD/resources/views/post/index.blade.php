<!DOCTYPE html>
<html lang="en">

<head>
    <title>Trang chủ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Table Post</h2>
        @if (session('notification'))
            <div class="alert alert-success" role="alert">
                {{ session('notification') }}
            </div>
        @endif
        <table class="table">
            <a href="{{ route('posts.create') }}" class="btn btn-primary">Thêm mới</a>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($post as $posts)
                    <tr>
                        <td>{{ $posts->id }}</td>
                        <td>{{ $posts->name }}</td>
                        <td>
                            <img src="/images/{{ $posts->image }}" alt="" height="100" width="100">
                        </td>
                        <td>{!! $posts->description !!}</td>
                        <td>
                            <a href="{{ route('posts.edit', $posts->id) }}" class="btn btn-success">Sửa</a>
                            <form action="{{ route('posts.destroy', $posts->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Bạn có muốn xóa ?')"
                                    class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
            {{-- <div class="card-footer clearfix"> --}}
            {{-- </div> --}}
        </table>
        <div class="container">
            {{ $allPosts->links() }}
        </div>

    </div>

</body>

</html>
