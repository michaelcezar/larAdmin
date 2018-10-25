<?php

namespace App\Http\Controllers\publics;

use App\Http\Controllers\Controller;
use App\UserStatus;
use Illuminate\Http\Request;


class UserClientStatusController extends Controller
{
    public function listStatus(){
		$status = new UserStatus();
		return response()->json($status->getAllActiveStatus());
	}
}
