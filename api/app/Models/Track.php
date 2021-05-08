<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Artist;
use App\Models\UserFavoriteTrack;

class Track extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'spotify_id', 'artist_id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
    public function userFavoriteTracks()
    {
        return $this->hasMany(UserFavoriteTrack::class);
    }
}
