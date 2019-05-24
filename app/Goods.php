<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    public $primaryKey ='goods_id';
    public $table='goods';
    public $timestamps=false;
}
