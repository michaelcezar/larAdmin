<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserStatus extends Model
{
    protected $table = 'user_client_status';
	public $timestamps = true;
	protected $fillable = array('description','created_at','updated_at','deleted_at');

	public function getAllActiveStatus(){
		return DB::table('user_client_status')->select('id', 'description')->whereNull('deleted_at')->get();
	}

}
