<?php

namespace App\Models;

use App\Models\Track;
use App\Models\Artist;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
    protected $primaryKey = 'id';
    protected $fillable = ['track_id', 'user_id', 'played_at'];

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
