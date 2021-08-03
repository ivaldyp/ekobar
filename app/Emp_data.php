<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emp_data extends Model
{
    protected $connection = 'sqlsrv';
    // protected $primaryKey = "id_emp"; 
    protected $table = "emp_data";
    
    public $incrementing = 'false';
    public $timestamps = false;
}
