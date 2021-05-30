<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Employee extends Model
{

    protected $guarded=[];
    protected $table="ATT_IN.tbl_raw_data";
}
