<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nabar extends Model
{
    protected $connection = 'sqlsrv';
	// protected $primaryKey = "id_emp"; 
	protected $table = "2021nabar";
	
	public $incrementing = 'false';
	public $timestamps = false;
}
