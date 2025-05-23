<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlackPhone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'phone'
    ];
}
