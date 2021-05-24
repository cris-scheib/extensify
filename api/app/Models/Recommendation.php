<?php

namespace App\Models;

use App\Models\Artist;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    protected $table = 'recommendations';
    protected $primaryKey = 'id';
    protected $fillable = ['artist_id', 'user_id', 'seed'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
