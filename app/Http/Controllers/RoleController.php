<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    public function index()
    {
        $dataExport = DB::table("roles")->select("*")->get(); 
        return $dataExport;
    }
    public function getUserRolesPermission(){
        $dataExport = DB::table("roles")->select("*")->get(); 
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $roles_id = DB::table('users')->where('id',$userId )->value('roles_id');
        
        $roleName = DB::table('roles')->select('name')->where('id',$user->roles_id)->value('name');

        $roles_permission = DB::table('roles_permission')->where('roles_id',$roles_id)->get()->toArray(); 
        $roles = [];
        foreach ( $roles_permission as $key => $row){
            $crud_guard  = DB::table('crud_guard')->where('roles_permission_id',$row->id)->get(); 
            $roles[$row->id] =array(
                'id'=>$row->id,
                'name' => $row->module,
                'crud_guard' => $crud_guard,
                'user_name'=> $user->firstname,
                'user_lastname'=> $user->lastname,
                'user_role'=> $roleName
            );
        }
        return response()->json($roles, 200);
    }
}
