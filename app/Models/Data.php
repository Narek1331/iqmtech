<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'project_id',
        'page',
        'ref',
        'phone',
        'browser',
        'device',
        'platform',
        'ip_address',
        'utm_term',
        'utm_source',
        'utm_campaign',
        'utm_medium',
        'utm_content',
        'latitude',
        'longitude',
        'gender',
        'age',
        'city',
        'region',
        'country',
        'mobile_operator',
        'address',
        'age',
        'comment',
        'status_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id','id');
    }

    public function status()
    {
        return $this->belongsTo(DataStatus::class,'status_id','id');
    }

}
