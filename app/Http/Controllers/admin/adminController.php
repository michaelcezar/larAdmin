<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ExtraClass\appConfig;

class adminController extends Controller
{
    public function inicio (){
    	

		return view('admin/home/home');
	}
}
