<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'roles_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role_permission($userId, $role_permission, $crude_guard){
        $user = User::findOrFail($userId);
        $roles_id = DB::table('users')->where('id',$userId )->value('roles_id');
        $roles_permission = DB::table('roles_permission')->where('roles_id',$roles_id)->Where('module', 'LIKE', "%{$role_permission}%") ->get(); 
        $crud_guard = DB::table('crud_guard')->where('roles_permission_id',$roles_permission[0]->id)->get(); 

        // echo  $crud_guard[0]->$crude_guard; 
        return  $crud_guard[0]->$crude_guard ;
    }
}
