<?php

namespace App\Http\Controllers\password;

use App\Http\Controllers\Controller;
use App\Http\Requests\password\resetPasswordRequest;
use App\Http\Requests\password\updatePasswordRequest;
use App\ExtraClass\appMessages;
use App\ExtraClass\sendMail;
use Illuminate\Http\Request;
use App\User;
use Session;
use Auth;
use Hash;
use DB;

class PasswordController extends Controller
{
    public function forgotPasswordView(){
        if (!Auth::check() or !(session()->has('userId'))){
            return view('forgotPassword/forgotPassword');
        } else {
            return back();
        }
    }

    public function resetPasswordView(){
        if (!Auth::check() or !(session()->has('userId'))){
           return view('forgotPassword/resetPassword');
        } else {
            return back();
        }
    }

    protected function sendPasswordResetToken(Request $request){
        $validatedData = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $user = User::where ('email', $request->email)->first();
        if ( !$user || $user->user_status == 3 ) {
            return response()->json(array( "error" => appMessages::returnMessage()->userNotFound ));
        } else if ($user->user_status == 2){
            return response()->json(array( "error" => appMessages::returnMessage()->userBlock ));
        } else {
            DB::table('password_resets')->where('email', $request->email)->delete();

            DB::table('password_resets')->insert([
                'email'      => $request->email,
                'token'      => str_random(60),
                'created_at' => \Carbon\Carbon::now()
            ]);

            $tokenData = DB::table('password_resets')->where('email', $request->email)->first();
            
            $user_name  = $user->name;
            $user_email = $request->email;

            $url = "http://".$request->server('HTTP_HOST')."/password/resetPassword?token=".$tokenData->token."&email=".$user_email;
    
            $sendMail = new sendMail();
            $sendMail->to_mail      = $user_email;
            $sendMail->to_name      = $user_name;
            $sendMail->subject      = 'Redefinição de Senha';
            $sendMail->email_layout = 'emails/forgotPassword';
            $sendMail->bodyMessage  = $url;

            if($sendMail->send()){
                return response()->json(array("success"  => appMessages::returnMessage()->successSendMail ));
            } else {
                return response()->json(array("error"    => appMessages::returnMessage()->errorSendMail ));
            }
        }    
    }

    protected function resetPassword(resetPasswordRequest $request){
        $tokenData = DB::table('password_resets')->where('token', $request->token)->where('email', $request->email)->first();
        if (!$tokenData) {
            return response()->json(array("error" => appMessages::returnMessage()->invalidResetPasswordToken ));
        } else {
            $user = User::where('email', $tokenData->email)->first();
            if ( !$user ) {
                return response()->json(array("error" => appMessages::returnMessage()->userNotFound ));
            } else {
                $user->password = Hash::make($request->password);
                $user->remember_token = null;
                if($user->save()){
                    DB::table('sessions')->where('user_id', $user->id)->delete();
                    DB::table('password_resets')->where('email', $user->email)->delete();
                    return response()->json(array("success" => appMessages::returnMessage()->successPasswordReset , "pageRedirect"=>"/login"));
                } else {
                    return response()->json(array("error" => appMessages::returnMessage()->errorPasswordReset ));
                }
            }
        }
    }

    protected function updatePassword(updatePasswordRequest $request){
        $user = Auth::user();
        if (Hash::check($request->currentPassword, $user->password)) {
            DB::table('sessions')->where('user_id', $user->id)->whereNotIn('id', [Session::getId()])->delete();
            $obj_user                 = User::find(Session::get('userId'))->first();
            $obj_user->password       = Hash::make($request->newPassword);
            $obj_user->remember_token = null;
            if($obj_user->save()){
                return response()->json(array("success" => appMessages::returnMessage()->successUpdatePassword ));
            } else {
                return response()->json(array("error"   => appMessages::returnMessage()->errorUpdatePassword ));
            }
        } else {
            return response()->json(array("error" => appMessages::returnMessage()->invalidCurrentPassword ));
        }
    }
}
