<?php

namespace App\Utils\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = ['id', 'city_id' , 'district_name'];

    protected $hidden = [];

    public $timestamps = false;

    public function city()
    {
        return $this->belongsTo('App\Utils\Models\City', 'city_id', 'id');
    }
}
