<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SysColumn extends Model
{
	protected $guarded=['id'];
	protected $dateFormat='Y-m-d H:i:s';


    //
	public function __construct(array $attributes = []){
		parent::__construct($attributes);
	}
}
