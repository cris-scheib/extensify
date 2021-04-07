<?php

namespace App\Models;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'spotify_id', 'image'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
