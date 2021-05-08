<?php

namespace App\Models;

use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Model;

class ArtistGenre extends Model
{
    protected $table = 'artist_genre';
    protected $primaryKey = 'id';
    protected $fillable = ['artist_id', 'genre_id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
