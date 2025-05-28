<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'global_limit',
        'daily_limit',
        'status',
        'token',
        'user_id',
        'created_by_admin'
    ];

    public function domains()
    {
        return $this->hasMany(ProjectDomain::class,'project_id','id');
    }

    public function datas()
    {
        return $this->hasMany(Data::class,'project_id','id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}
