<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $connection='sqlsrv';
    protected $table='Project';
}
