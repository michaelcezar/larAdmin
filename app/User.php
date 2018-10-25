<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'user_status', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public  function getAllUsers(){
        return DB::table('users')
            ->leftJoin('user_type', 'user_type.id', '=', 'users.user_type')
            ->leftJoin('user_client_status', 'user_client_status.id', '=', 'users.user_status')
            ->select('users.id', 'users.name', 'users.email', 'users.user_type', 'users.user_status', 'user_type.description as type_description', 'user_client_status.description as user_status_description')
            //->where('users.id', '1')
            //->orWhere('name', 'John')
            // ->whereBetween('votes', [1, 100])
            // ->whereNotBetween('votes', [1, 100])
            //->whereIn('id', [1, 2, 3])
            // ->whereNotIn('id', [1, 2, 3])
            //  ->whereNotNull('updated_at')
            // ->whereDate('created_at', '2016-12-31')
            //  ->where('name', 'like', 'T%')
            /*
            ->where([
                ['status', '=', '1'],
                ['subscribed', '<>', '1'],
            ])
            */
            ->whereNull('users.deleted_at')
            ->get();

    }

    public function getUser(){
       $name   = $this->name;
       $email  = $this->email;
       $type   = $this->user_type;
       $status = $this->user_status;

        $users = DB::table('users')
            ->leftJoin('user_type', 'user_type.id', '=', 'users.user_type')
            ->leftJoin('user_client_status', 'user_client_status.id', '=', 'users.user_status')
            ->select('users.id', 'users.name', 'users.email', 'users.user_type', 'users.user_status', 'user_type.description as type_description', 'user_client_status.description as user_status_description')
            ->when($name, function ($query, $name) {
                return $query->where('users.name', 'like',  '%'.$name.'%');
            })

            ->when($email, function ($query, $email) {
                return $query->where('users.email', 'like',  '%'.$email.'%');
            })

            ->when($type, function ($query, $type) {
                return $query->whereIn('users.user_type', $type);
            })

            ->when($status, function ($query, $status) {
                return $query->whereIn('users.user_status', $status);
            }, function ($query) {
                return $query->whereNull('users.deleted_at');
            })
           
            ->get();

            return $users;
    }

    public function countUsers(){
        $countUsers = DB::table('user_client_status')
        ->leftJoin('users', 'users.user_status', '=', 'user_client_status.id')
        ->select(DB::raw(' user_client_status.id, user_client_status.description, count(users.id) as user_count'))
        ->groupBy('user_client_status.id','user_client_status.description')
        ->get();

        return $countUsers;
    }
}
