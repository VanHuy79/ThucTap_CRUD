<?php

namespace App\Models;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory;
    protected $table = 'file';
    protected $primaryKey = 'id';

    protected $fillable = [
        'image',
        'user_id'
    ];
    // Quan hệ bảng File với Post
    public function post()
    {
        return $this->belongsTo(Post::class, 'field_image', 'image');
    }
    // Quan hệ bảng File với Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
