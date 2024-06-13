<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $hidden = ['pivot'];
    protected $fillable = [
        'name',
        'file',
        'thumbnail'
    ];
    public function singers()
    {
        return $this->belongsToMany(Singer::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function Album()
    {
        return $this->belongsToMany(Album::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
