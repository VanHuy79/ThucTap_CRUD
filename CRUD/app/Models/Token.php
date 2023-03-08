<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Token extends Model
{
    use HasFactory;

    protected $table = 'tokens';
    protected $primaryKey = 'id';

    // guarded là muốn lấy all tất cả các giá trị trong bảng
    protected $fillable = [
        'user_id',
        'token',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
