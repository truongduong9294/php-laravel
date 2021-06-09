<?php
namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use DB;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function getModel()
    {
        return \App\Models\User::class;
    }

    public function listUser() 
    {
        $listRole = DB::table('users')
                    ->join('roles','users.role_id', '=' ,'roles.id')
                    ->select('users.*','roles.role_name')
                    ->orderBy('created_at', 'desc')
                    ->paginate(3);
        return $listRole;
    }

    public function checkEmail($email)
    {
        return $checkEmail = DB::table('users')->where('email', $email)->first();
    }

    public function addToken($token,$email)
    {
        $result = false;
        $addToken = DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token
        ]);
        if ($addToken) {
            $result = true;
        }
        return $result;
    }

    public function findToken($token)
    {
        $email = DB::table('password_resets')->where('token', $token)->first();
        return $email;
    }

    public function deleteToken($token)
    {
        $result = false;
        $deleteToken = DB::table('password_resets')->where('token', $token)->delete();
        if ($deleteToken) {
            $result = true;
        }
        return $result;
    }

    public function passwordReset($email,$password)
    {
        $result = false;
        $resetPassword = DB::table('users')
                        ->where('email', $email)
                        ->update([
                            'password' => $password,
                        ]);
        if ($resetPassword) {
            $result = true;
        }
        return $result;
    }
}