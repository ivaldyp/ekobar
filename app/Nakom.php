<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nakom extends Model
{
    protected $connection = 'sqlsrv';
	// protected $primaryKey = "id_emp"; 
	protected $table = "2021nakom";
	
	public $incrementing = 'false';
	public $timestamps = false;
}
