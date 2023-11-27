<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nabar extends Model
{
    protected $connection = 'server12';
	// protected $primaryKey = "id_emp"; 
	protected $table = "bpadkobar.dbo.data_nabar";
	
	// public $incrementing = 'false';
	public $timestamps = false;
}
