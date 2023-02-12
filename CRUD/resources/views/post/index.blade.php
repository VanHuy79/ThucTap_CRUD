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
            {{-- @if (Auth::check()) --}}
            <a href="/blog/create" class="btn btn-primary">Thêm mới</a>
            {{-- @endif --}}
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th style="width: 200px, display:flex">Image</th>
                    <th>Description</th>
                    <th>Name Created</th>
                    <th style="width: 75px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($post as $posts)
                    <tr>
                        <td>{{ $posts->id }}</td>
                        <td>{{ $posts->name }}</td>
                        <td>
                            <img src="/images/{{ $posts->field_image }}" class="img-responsive"
                                style="max-height: 50px; max-width: 50px;" alt="" srcset="">
                            {{-- @endforeach --}}
                            {{-- @endif --}}
                        </td>
                        <td>{!! $posts->description !!}</td>
                        <td>{{ $posts->user->name }}</td>
                        <td style="display: flex">
                            {{-- @if (isset(Auth::user()->id) && Auth::user()->id == $posts->user_id) --}}
                            <a href="/blog/{{ $posts->id }}/edit" class="btn btn-success">Sửa</a>
                            {{-- @endif --}}
                            {{-- @if (isset(Auth::user()->id) && Auth::user()->id == $posts->user_id) --}}
                            <form action="/blog/{{ $posts->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Bạn có muốn xóa ?')"
                                    class="btn btn-danger">Xóa</button>
                            </form>
                            {{-- @endif --}}

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>
