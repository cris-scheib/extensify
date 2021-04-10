<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Artist;
use App\Models\UserTrack;

class Track extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'spotify_id', 'artist_id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
    public function userTrack()
    {
        return $this->hasMany(UserTrack::class);
    }
}
