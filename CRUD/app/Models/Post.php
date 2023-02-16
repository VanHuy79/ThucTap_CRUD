<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use HasFactory;
    // use Sluggable;
    protected $table = 'post';
    protected $primaryKey = 'id';

    // guarded là muốn lấy all tất cả các giá trị trong bảng
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'field_image',
    ];
    // Quan hệ bảng post với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Quan hệ bảng Post với File
    public function image()
    {
        return $this->hasOne(File::class, 'image', 'field_image');
    }
}
