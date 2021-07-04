<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Repositories\User\UserRepositoryInterface;

class AuthController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_name' => 'required|min:4|max:20',
            'password'  => 'required|min:4|max:20'
        ]);
        $error_array = array();
        $success_output = '';
        $userLogin = [
            'user_name' => $request->get('user_name'),
            'password'  => $request->get('password'),
        ];
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages; 
            }
        }else {
            if (Auth::attempt($userLogin)) {
                $success_output = '<div class="alert alert-success">Login Success</div>';
            }else {
                $error_array[] = 'Invalid Username or Password';
            }
        }

        $output = array(
            'error'     => $error_array,
            'success'   => $success_output,
        );
        echo json_encode($output);
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_name'   => 'required|min:4|max:20',
            'name'       => 'required|min:4|max:20',
            'email'      => 'required|email|min:4|max:40',
            'avatar'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'   => 'required|min:4|max:20'
        ]);
        $error_array = array();
        $success_output = '';
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages; 
            }
        }else {
            $user = array();
            $user['user_name'] = $request->get('user_name');
            $user['name'] = $request->get('name');
            $user['email'] = $request->get('email');
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $arrayImage =  explode( '.', $image->getClientOriginalName());
                $user['avatar'] = $arrayImage[0].'-'.time().'.'.$arrayImage[1];
            }
            $user['role_id'] = 2;
            $user['password'] = bcrypt($request->get('password'));
            $user = $this->userRepo->create($user);
            if ($user) {
                $image->move(public_path('uploads'), $user['avatar']);
                $success_output = '<div class="alert alert-success">Register Success</div>';
            }else {
                $error_array[] = 'Registration Failed';
            }
        }
        $output = array(
            'error'     => $error_array,
            'success'   => $success_output,
        );
        echo json_encode($output);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
