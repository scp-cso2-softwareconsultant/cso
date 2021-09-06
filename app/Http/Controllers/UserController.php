<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function saveUser(Request $request)
    {
        
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        
        $success = false;
        if(  $raw_data-> id_exist && User::findOrFail( $raw_data->id ) ){
            $success = DB::table('users')->where('id',$raw_data->id )->update(array(
                'firstname' => $raw_data->firstname,
                'lastname' => $raw_data->lastname,
                'email' => $raw_data->email,
                'password' => Hash::make($raw_data->password ),
                'roles_id' => $raw_data->roles_id
             ));
        }else{
            $success = User::insert([
                'firstname' => $raw_data->firstname,
                'lastname' => $raw_data->lastname,
                'email' => $raw_data->email,
                'password' => Hash::make($raw_data->password ),
                'roles_id' => $raw_data->roles_id
            ]);
        }
         
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
        
    
    }
    

    public function deleteUser(Request $request)
    {
        $success = false;
        $deleted_id = json_decode($request['id']);
        $success = User::destroy($deleted_id);
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

}
