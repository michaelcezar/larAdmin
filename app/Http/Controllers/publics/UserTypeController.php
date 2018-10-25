<?php

namespace App\Http\Controllers\publics;

use App\Http\Controllers\Controller;
use App\UserType;
use Illuminate\Http\Request;

class UserTypeController extends Controller
{
    public function listType(){
		$tipo = new UserType();
		return response()->json($tipo->getAllActiveType());
	}
}
