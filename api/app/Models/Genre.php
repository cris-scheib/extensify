<?php

namespace App\Models;

use App\Models\Artist;
use App\Models\ArtistGenre;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_genre');
    }
    public function artistGenre()
    {
        return $this->hasMany(ArtistGenre::class);
    }

}
