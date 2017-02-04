<?php

namespace App\Models\Busi;

use Illuminate\Database\Eloquent\Model;


class VisitLineStore extends BaseModel
{
    //
	 protected $table = 'visit_line_store';

	 protected $guarded = ['id'];
	 
	 protected $with = ['employee','line','store'];
	 
	 public function employee(){
	 	return $this->hasOne(Employee::class, 'id', 'femp_id');
	 }
	 
	 public function line(){
	 	return $this->hasOne(VisitLine::class, 'id', 'fline_id');
	 }

	 public function store(){
         return $this->hasOne(Store::class, 'id', 'fstore_id');
     }
}
