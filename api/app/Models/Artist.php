<?php

namespace App\Models;

use App\Models\Genre;
use App\Models\UserFavoriteArtist;
use App\Models\UserFollowedArtist;
use App\Models\ArtistGenre;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'spotify_id', 'image'];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    public function artistGenre()
    {
        return $this->hasMany(ArtistGenre::class);
    }
    public function userFavoriteArtist()
    {
        return $this->hasMany(UserFavoriteArtist::class);
    }
    public function userFollowedArtist()
    {
        return $this->hasMany(UserFollowedArtist::class);
    }
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
}
