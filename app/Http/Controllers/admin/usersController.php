<?php

namespace App\Http\Controllers\admin;

use App;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\userRequest;
use App\Http\Requests\admin\updateUserRequest;
use App\Http\Requests\admin\updatePasswordRequest;
use App\ExtraClass\appMessages;
use App\ExtraClass\sendMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use Illuminate\Http\Request;
use Session;
use Validator;

class usersController extends Controller
{
   public function listView(){
		return view('admin/users/userList');
	}

	public function newView(){
		return view('admin/users/userNew');
	}

	protected function new(userRequest $request){
		if(User::create([
			'name'        => $request->name,
			'email'       => $request->email,
			'password'    => Hash::make($request->password),
			'user_type'   => $request->type,
			'user_status' => $request->status
		])){
			return response()->json(array("success" => appMessages::returnMessage()->succesCreateUser ));
		} else {
			return response()->json(array("error"   => appMessages::returnMessage()->errorCreateUser ));
		}
	}

	protected function list(Request $request){
		$users              = new User();
		$users->name        = $request->name;
		$users->email       = $request->email;
		$users->user_type   = $request->type;
		$users->user_status = $request->status;
		return response()->json($users->getUser());
	}

	protected function update(updateUserRequest $request){
		$user              = User::find($request->id);
		$user->name        = $request->name;
		$user->email       = $request->email;
		$user->user_type   = $request->type;
		$user->user_status = $request->status;
		if($user->save()){
			return response()->json(array("success" =>  appMessages::returnMessage()->successUpdateUser ));
		} else {
			return response()->json(array("error"   =>  appMessages::returnMessage()->errorUpdateUser ));
		}
	}

	protected function updatePassword(updatePasswordRequest $request){
		$user = User::find($request->id);
    	$user->password       = Hash::make($request->newPassword);
    	$user->remember_token = null;
        if($user->save()){
        	DB::table('sessions')->where('user_id', $user->id)->whereNotIn('id', [Session::getId()])->delete();
			return response()->json(array("success" =>  appMessages::returnMessage()->successUpdatePasswordUser ));
		} else {
			return response()->json(array("error"   =>  appMessages::returnMessage()->errorUpdatePasswordUser ));
		}
	}

	protected function redefinePassword(Request $request){
		$validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);

        $user = User::where ('id', $request->id)->first();
        if ( !$user ) {
            return response()->json(array( "error" => appMessages::returnMessage()->userNotFound ));
        } else {
        	$user->password       = Hash::make(str_random(20));
    		$user->remember_token = null;
    		$user->save();
			
			DB::table('sessions')->where('user_id', $user->id)->whereNotIn('id', [Session::getId()])->delete();

            DB::table('password_resets')->where('email', $request->email)->delete();

            DB::table('password_resets')->insert([
                'email'      => $user->email,
                'token'      => str_random(60),
                'created_at' => \Carbon\Carbon::now()
            ]);

            $tokenData = DB::table('password_resets')->where('email', $user->email)->first();
            
            $user_name  = $user->name;
            $user_email = $user->email;

            $url = "http://".$request->server('HTTP_HOST')."/password/resetPassword?token=".$tokenData->token."&email=".$user_email;
            
            $sendMail = new sendMail();
            $sendMail->to_mail      = $user_email;
            $sendMail->to_name      = $user_name;
            $sendMail->subject      = 'Redefinição de Senha Solicitada';
            $sendMail->email_layout = 'emails/adminResetPassword';
            $sendMail->bodyMessage  = $url;

            if($sendMail->send()){
                return response()->json(array("success"  => appMessages::returnMessage()->successSendMail ));
            } else {
                return response()->json(array("error"    => appMessages::returnMessage()->errorSendMail ));
            }
        } 
	}

	protected function block(Request $request){
		$validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
		$user = User::find($request->id);
    	$user->user_status = 2;
        if($user->save()){
			return response()->json(array("success" => appMessages::returnMessage()->successBlockUser ));
		} else {
			return response()->json(array("error"   => appMessages::returnMessage()->errorBlockUser ));
		}
	}

	protected function activate(Request $request){
		$validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
		$user = User::find($request->id);
    	$user->user_status = 1;
        if($user->save()){
			return response()->json(array("success" => appMessages::returnMessage()->successActivateUser ));
		} else {
			return response()->json(array("error"   => appMessages::returnMessage()->errorActivateUser ));
		}
	}

	protected function delete(Request $request){
		$validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
		$user = User::find($request->id);
    	$user->user_status = 3;
    	$user->deleted_at = \Carbon\Carbon::now();
        if($user->save()){
			return response()->json(array("success" => appMessages::returnMessage()->successDeleteUser ));
		} else {
			return response()->json(array("error"   => appMessages::returnMessage()->errorDeleteUser ));
		}
	}

	protected function restore(Request $request){
		$validatedData = $request->validate([
            'id' => 'required|numeric',
        ]);
		$user = User::find($request->id);
    	$user->user_status = 1;
    	$user->deleted_at = null;
        if($user->save()){
			return response()->json(array("success" => appMessages::returnMessage()->successRestoreUser ));
		} else {
			return response()->json(array("error"   => appMessages::returnMessage()->errorRestoreUser ));
		}
	}

	protected function countUser(){
		$users = new User();
		return response()->json(array("success" =>$users->countUsers()));
	}

}