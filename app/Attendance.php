<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    public $primaryKey = 'employee_id';

    public $builiding_id = 'building_id';
}
