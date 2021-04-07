<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistGenre extends Model
{
    protected $table = 'artist_genre';
    protected $primaryKey = 'id';
    protected $fillable = ['artist_id', 'genre_id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'id', 'artist_id');
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
