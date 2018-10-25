<?php
namespace App\Http\Controllers\login;

use App\Http\Controllers\Controller;
use App\Http\Requests\login\loginRequest;
use App\ExtraClass\appMessages;
use Auth;
use Request;
use Session;

class LoginController extends Controller {

  public function LoginShow(){
    if (!Auth::check() or !(session()->has('userId'))){
      return view('login/login');
    } else {
      return redirect('/admin');
    }
  }

  protected function login(loginRequest $request){
    if (Auth::attempt(["email"=>$request->email, "password" => $request->password],$request->remember)) {
      
      if(Auth::user()->user_status == 1){
        session([
          'userId' =>    Auth::user()->id,
          'userName' =>  Auth::user()->name,
          'userMail' =>  Auth::user()->email
        ]);
        return response()->json(array("success" => "", "pageRedirect"=>"/admin" ));
      } else if (Auth::user()->user_status == 2) {
        Auth::logout();
        return response()->json(array("error"   => appMessages::returnMessage()->userBlock ));
      } else {
        Auth::logout();
        return response()->json(array("error"   => appMessages::returnMessage()->errorUserLogin ));
      }
      
    } else {
      return response()->json(array("error"   => appMessages::returnMessage()->errorUserLogin ));
    }
  }

  public function logout(Request $request) {
    Auth::logout();
    Session::flush();
    return redirect('/login');
  }
}