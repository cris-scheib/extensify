<?php

namespace App\Models;

use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserTrack extends Model
{
    protected $table = 'user_track';
    protected $primaryKey = 'id';
    protected $fillable = ['track_id', 'user_id'];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
