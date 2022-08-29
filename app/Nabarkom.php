<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nabarkom extends Model
{
	protected $connection = 'sqlsrv';
	// protected $primaryKey = "id_emp"; 
	protected $table = "bpadkobar.dbo.data_nabarkom";
	
	public $incrementing = 'false';
	public $timestamps = false;
}
