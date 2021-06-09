<?php
namespace App\Repositories\Role;

use App\Repositories\BaseRepository;
use DB;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{

    public function getModel()
    {
        return \App\Models\Role::class;
    }

    public function getList()
    {
        return DB::table('roles')->orderBy('id', 'desc')->paginate(2);
    }

    public function checkUser()
    {
        return DB::table('roles')
        ->join('users','roles.id', '=' ,'users.role_id')
        ->pluck('roles.id');
    }
}