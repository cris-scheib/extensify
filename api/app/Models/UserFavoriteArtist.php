<?php

namespace App\Models;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserFavoriteArtist extends Model
{
    protected $table = 'user_favorite_artist';
    protected $primaryKey = 'id';
    protected $fillable = ['artist_id', 'user_id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
