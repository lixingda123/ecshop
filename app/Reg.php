<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reg extends Model
{
    public $primaryKey ='user_id';
    public $table='user';
    public $timestamps=false;
}
