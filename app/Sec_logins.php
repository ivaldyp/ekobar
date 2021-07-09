<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sec_logins extends Model
{
    protected $connection = 'sqlsrv';
    protected $primaryKey = "ids"; 
    protected $table = "sec_logins";
    public $timestamps = false;
}
