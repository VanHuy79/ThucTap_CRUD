<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sửa Post</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h2>Sửa mới Post</h2>
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $post->name }}">
            </div>

            <div class="form-group">
                <label for="pwd">Description:</label>
                <textarea class="form-control" id="description" name="description">{!! $post->description !!}</textarea>
            </div>

            <div class="form-group">
                <label for="pwd">Image:</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="/images/{{ $post->image }}" width="200" height="200">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>

</body>
<script src="https://cdn.ckeditor.com/4.20.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>

</html>
