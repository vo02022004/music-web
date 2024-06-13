<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $hidden = [
        'pivot',
    ];
    public function singers()
    {
        return $this->belongsToMany(Singer::class);
    }
    public function songs()
    {
        return $this->belongsToMany(Song::class);
    }
}
