<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Singer extends Model
{
    use HasFactory;
    protected $hidden = [
        'pivot',
    ];
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
