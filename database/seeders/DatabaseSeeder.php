<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        // \App\Models\User::factory(10)->create();;
        DB::statement("SET foreign_key_checks=0");
        DB::table('users')->truncate();
        DB::table('roles')->truncate();
        DB::table('roles_permission')->truncate();
        DB::table('crud_guard')->truncate();
        DB::statement("SET foreign_key_checks=1");

        



        $collection = array(

            // =================================================================================================== 
            'Administrator' => array(
                "login"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Users"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Dashboard" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "CSOIndicator" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Assessment" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "FinanceTracker" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "CSOProfile"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "ProjectTrackingDocuments"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "LMS"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                )
            ),
            // ================================================================
            'Contributor' => array(
                "login"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Users"=>array(
                    'create'=>false,
                    'read'=>false,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>false,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "Dashboard" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "CSOIndicator" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Assessment" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "FinanceTracker" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "CSOProfile"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "ProjectTrackingDocuments"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "LMS"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                )
            ),
    
            'Viewer' => array(
                "login"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Users"=>array(
                    'create'=>false,
                    'read'=>false,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>false,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "Dashboard" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>false,
                    'download'=>true,
                    'print'=>false,
                    'upload'=>false,
                ),
                "CSOIndicator" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "Assessment" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "FinanceTracker" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "CSOProfile"=>array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "ProjectTrackingDocuments"=>array(
                    'create'=>false,
                    'read'=>false,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>false,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "LMS"=>array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                )
            ),
    
            'Limited Contributor' => array(
                "login"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Users"=>array(
                    'create'=>false,
                    'read'=>false,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>false,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "Dashboard" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>false,
                ),
                "CSOIndicator" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Assessment" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>false,
                ),
                "FinanceTracker" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>false,
                ),
                "CSOProfile"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "ProjectTrackingDocuments"=>array(
                    'create'=>false,
                    'read'=>false,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>false,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "LMS"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                )
            ),
            'Contributor' => array(
                "login"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Users"=>array(
                    'create'=>false,
                    'read'=>false,
                    'update'=>false,
                    'delete'=>false,
                    'view'=>false,
                    'export'=>false,
                    'download'=>false,
                    'print'=>false,
                    'upload'=>false,
                ),
                "Dashboard" => array(
                    'create'=>false,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>false,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "CSOIndicator" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "Assessment" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "FinanceTracker" => array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "CSOProfile"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "ProjectTrackingDocuments"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                ),
                "LMS"=>array(
                    'create'=>true,
                    'read'=>true,
                    'update'=>true,
                    'delete'=>true,
                    'view'=>true,
                    'export'=>true,
                    'download'=>true,
                    'print'=>true,
                    'upload'=>true,
                )
            )
        );

        

        foreach ( $collection  as $role => $roles_permission){

            $roles_id = DB::table('roles')->insertGetId([
                'name' => $role,
                'guard_name' => 'web',
            ]);

            $users = DB::table('users')->insert([
                'firstname' =>  $role,
                'lastname' => 'web',
                'email'=>  $role . '@email.com',
                'password'=>Hash::make($role),
                'roles_id' => $roles_id,
            ]);

            foreach ($roles_permission as $module => $crude_guard ){
                $roles_permission_id = DB::table('roles_permission')->insertGetId([
                    'module' => $module,
                    'roles_id' => $roles_id,
                ]);
                $crude_guard = DB::table('crud_guard')->insert([
                    'roles_permission_id' => $roles_permission_id,
                    'create' => $crude_guard['create'],
                    'read' => $crude_guard['read'],
                    'update' => $crude_guard[ 'update'],
                    'delete'=> $crude_guard[ 'delete' ],
                    'view' => $crude_guard[ 'view' ],
                    'export' =>$crude_guard[ 'export'  ],
                    'download' => $crude_guard[ 'download'  ],
                    'print' => $crude_guard[ 'print' ],
                    'upload' => $crude_guard['upload'],
                ]);
            }
        }

        DB::table('users')->insertGetId([
            'firstname' => 'admin',
            'lastname' => 'web',
            'email'=>'admin@email.com',
            'password'=>Hash::make('password'),
            'roles_id' => 1,
        ]);




        $project_tracking = array(
            1=> array(
                "Implementation_vs_target"=>"",
                "Objective"=>"",
                "challanges"=>"",
                "estimated_progress"=>0,
                "indicators"=>"",
                "next_month_planning"=>""
            ),
            2=>array(
                "Implementation_vs_target"=>"",
                "Objective"=>"",
                "challanges"=>"",
                "estimated_progress"=>0,
                "indicators"=>"",
                "next_month_planning"=>""
            ),
            3=>array(
                "Implementation_vs_target"=>"",
                "Objective"=>"",
                "challanges"=>"",
                "estimated_progress"=>0,
                "indicators"=>"",
                "next_month_planning"=>""
            ),
            4=> array(
                "Implementation_vs_target"=>"",
                "Objective"=>"",
                "challanges"=>"",
                "estimated_progress"=>0,
                "indicators"=>"",
                "next_month_planning"=>""
            )
        );
        $typeOfSupport =  array(
            1=>'LRO',
            2=>'LRO-supported',
            3=>'Private Sector',
            4=>'LGU',
            5=>'academe',
            6=>'other CSO/CSO network',
            7=>'donor'
        );
        foreach ($typeOfSupport  as $key => $support ){
        
            DB::table('type_of_support')->insert([
                'name'=> $support 
            ]);
        }
    }
}
