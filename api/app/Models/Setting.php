<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Setting extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'key', 'value', 'user_id'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
