<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserType extends Model
{
    protected $table = 'user_type';
	public $timestamps = true;
	protected $fillable = array('description','created_at','updated_at','deleted_at');

	public function getAllActiveType(){
		return DB::table('user_type')->select('id', 'description')->whereNull('deleted_at')->get();
	}
}
