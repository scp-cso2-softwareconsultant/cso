<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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
        return DB::table('users')->where('id',$userId )->get();
    }
}
