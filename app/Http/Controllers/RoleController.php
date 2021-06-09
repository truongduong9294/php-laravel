<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Repositories\Role\RoleRepositoryInterface;
use Validator;
class RoleController extends Controller
{
    protected $roleRepo;

     /**
     * Initialization And Depency Injection.
     *
     * @return $roleRepo
     */

    public function __construct(RoleRepositoryInterface $roleRepo)
    {
        $this->roleRepo = $roleRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleRepo->getList();
        $checkUser = $this->roleRepo->checkUser();
        return view('backend.pages.role.list', compact('roles','checkUser'));
    }

    /**
     * Store a new Role and Edit Role
     *
     * @param  \App\Http\Requests\Request  $request
     * @return Illuminate\Http\Response
     */

    public function process(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'role_name' => 'required|min:4|max:20',
        ]);
        $error_array = array();
        $success_output = '';
        $category = array();
        $dataMode = '';
        $role = array();
        if ($validation->fails()) {
            foreach ($validation->messages()->getMessages() as $field_name => $messages) {
                $error_array[] = $messages; 
            }
        }else {
            if ($request->get('button_action') == 'insert') {
                $dataMode = 'insert';
                $role['role_name'] = $request->get('role_name');
                $role = $this->roleRepo->create($role);
                $success_output = '<div class="alert alert-success">Data Inserted</div>';
            }
            if ($request->get('button_action') == 'update') {
                $dataMode = 'update';
                $roleId = $request->get('role_id');
                $role['role_name'] = $request->get('role_name');
                $role = $this->roleRepo->update($roleId,$role);
                $success_output = '<div class="alert alert-success">Data Updated</div>';
            }
        }
        $output = array(
            'error'     => $error_array,
            'success'   => $success_output,
            'data'      => $role,
            'dataMode'  => $dataMode
        );
        echo json_encode($output);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getdata (Request $request)
    {
        $id = $request->input('id');
        $role = $this->roleRepo->find($id);
        $output = array(
            'role_name'    =>  $role->role_name,
        );
        echo json_encode($output);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */

    public function delete(Request $request) 
    {
        $success_output = '';
        $role = $this->roleRepo->delete($request->input('id'));
        if ($role) {
            $success_output = 'Data Deleted';
        }
        $output = array(
            'success_output' => $success_output
        );
        return json_encode($output);
    }
}
