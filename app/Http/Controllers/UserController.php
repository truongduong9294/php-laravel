<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;
use Mail;
use Illuminate\Support\Str;
use File;

class UserController extends Controller
{

    protected $userRepo;
    protected $roleRepo;

    /**
     * Initialization And Depency Injection.
     *
     * @return $userRepo, $roleRepo
     */

    public function __construct(UserRepositoryInterface $userRepo, RoleRepositoryInterface $roleRepo)
    {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() 
    {
        $users = $this->userRepo->listUser();
        return view('backend.pages.user.list', compact('users'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $roles = $this->roleRepo->getAll();
        return view('backend.pages.user.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(UserRequest $request)
    {
        $user = array();
        $user['user_name'] = $request->get('user_name');
        $user['name'] = $request->get('name');
        $user['email'] = $request->get('email');
        $image = $request->file('avatar');
        $arrayImage =  explode( '.', $image->getClientOriginalName());
        $user['avatar'] = $arrayImage[0].'-'.time().'.'.$arrayImage[1];
        $user['role_id'] = $request->get('role_id');
        $user['password'] = bcrypt($request->get('password'));
        $user = $this->userRepo->create($user);
        if ($user) {
            $image->move(public_path('uploads'), $user['avatar']);
            return redirect()->route('user.list')->with('success', 'Add User successs');
        }else {
            return back()->with('fail', 'Add User fail');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $product
     * @return \Illuminate\Http\Response
     */

    public function edit($id, $current)
    {
        $roles = $this->roleRepo->getAll();
        $user = $this->userRepo->find($id);
        return view('backend.pages.user.edit', ['roles' => $roles, 'user' => $user, 'currentPage' => $current]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $product
     * @return \Illuminate\Http\Response
     */

    public function update(UserRequest $request, $id)
    {
        $currentPage = $request->get('current_page');
        $user = array();
        $user['user_name'] = $request->get('user_name');
        $user['name'] = $request->get('name');
        $user['email'] = $request->get('email');
        $image = $request->file('avatar');
        $arrayImage =  explode( '.', $image->getClientOriginalName());
        $user['avatar'] = $arrayImage[0].'-'.time().'.'.$arrayImage[1];
        $user['role_id'] = $request->get('role_id');
        $user['password'] = bcrypt($request->get('password'));
        $userOld = $this->userRepo->find($id);
        if ($userOld) {
            $imagePath = public_path().'\uploads\\'.$userOld->avatar;
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            $user = $this->userRepo->update($id,$user);
            if ($user) {
                $image->move(public_path('uploads'), $user['avatar']);
                return redirect()->route('user.list', ['page' => $currentPage])->with('success', 'Edit User Successs');
            }else {
                return back()->with('fail', 'Edit User Fail');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $product
     * @return \Illuminate\Http\Response
     */

    public function destroy($id, $currentPage)
    {

        $userOld = $this->userRepo->find($id);
        $imageDelete = $userOld->avatar;
        $user = $this->userRepo->delete($id);
        $imagePath = public_path().'\uploads\\'.$imageDelete;
        if ($user) {
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            return redirect()->route('user.list', ['page' => $currentPage])->with('success', 'Delete User successs');
        }else {
            return back()->with('fail', 'Delete User fail');
        }
    }

    /**
     * Show the form login.
     *
     * @return \Illuminate\Http\Response
     */

    public function login()
    {
        return view('backend.login');
    }

    /**
     * Check user name and password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function loginProcess(Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|min:4|max:30',
            'password' => 'required',
        ]);
        $fieldLogin = array();
        $fieldLogin = [
            'user_name' => $request->get('user_name'),
            'password'  => $request->get('password'),
        ];
        if (Auth::attempt($fieldLogin)) {
            return redirect()->route('user.list');
        }else {
            return back()->with('message', 'Invalid username or password');
        }
    }

    /**
     * Logout
     *
     * @return
     */

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function forgot()
    {
        return view('backend.email');
    }

    public function register()
    {

        $roles = $this->roleRepo->getAll();
        return view('backend.register', compact('roles'));
    }

    public function registerProcess(UserRequest $request)
    {
        $user = array();
        $user['user_name'] = $request->get('user_name');
        $user['name'] = $request->get('name');
        $user['email'] = $request->get('email');
        $image = $request->file('avatar');
        $arrayImage =  explode( '.', $image->getClientOriginalName());
        $user['avatar'] = $arrayImage[0].'-'.time().'.'.$arrayImage[1];
        $user['role_id'] = $request->get('role_id');
        $user['password'] = bcrypt($request->get('password'));
        $user = $this->userRepo->create($user);
        if ($user) {
            $image->move(public_path('uploads'), $user['avatar']);
            return redirect()->route('user.login')->with('success', 'Register Successs');
        }else {
            return back()->with('fail', 'Register Fail');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function forgotProcess(Request $request)
    {
        $email = $request->get('email');
        $user = $this->userRepo->checkEmail($email);
        $data = [
            'user_name' => $user->user_name,
            'name'      => $user->name,
            'token'     => Str::random(32),
            'email'     => $user->email
        ];
        $email = $user->email;
        $name  = $user->name;
        if ($user) {
            $addToken = $this->userRepo->addToken($data['token'],$data['email']);
            Mail::send('backend.reset',$data, function($message) use ($email, $name){
                $message->from('duong9294.nta@gmail.com','DuongNTA');
                $message->to($email,$name);
                $message->subject('Reset Password');
            });
        }else {
            return redirect()->route('forgot')->with('message','Email does not exist');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $product
     * @return \Illuminate\Http\Response
     */

    public function resetPasword($token)
    {
        $email = $this->userRepo->findToken($token);
        if ($token) {
            $deleteToken = $this->userRepo->deleteToken($token);
            if ($deleteToken) {
                return view('backend.form_reset',compact('email'));
            }else {
                echo "token has been delete";
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $product
     * @return \Illuminate\Http\Response
     */

    public function resetProcess(Request $request)
    {
        $password = bcrypt($request->get('password'));
        $email = $request->get('email');
        $passwordReset = $this->userRepo->passwordReset($email,$password);
        if($passwordReset){
            return redirect()->route('user.login')->with('message', 'Change Password Successs');
        }
    }
}
