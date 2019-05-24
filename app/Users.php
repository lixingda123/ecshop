<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public $primaryKey ='user_id';
    public $table='users';
    public $timestamps=false;
    protected $fillable=[
        'brand_name',
        'brand_url',
        'brand_logo',
        'brand_desc',
    ];
}