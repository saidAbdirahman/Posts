<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    use HasFactory;
    protected $fillable = ['title', 'content', 'user_id', 'thumbnail',];

    public function user(): Belongsto
    {
        return $this->belongsTo(User::class);
    }
}
