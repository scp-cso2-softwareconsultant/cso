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
        return User::insert([
            'firstname' => $raw_data->firstname,
            'lastname' => $raw_data->lastname,
            'email' => $raw_data->email,
            'password' => Hash::make($raw_data->password ),
            'role_id' => $raw_data->role_id
        ]);
    
    }
    

}
