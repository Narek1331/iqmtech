<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataStatus extends Model
{
    // Disable automatic created_at and updated_at handling
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'data_id',
        'status_id',
    ];
}
