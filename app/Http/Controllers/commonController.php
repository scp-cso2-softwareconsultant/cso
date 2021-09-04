<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\csoExport;
use Excel;
use App\Models\User;

class commonController extends Controller
{
    public function getLROStatus(){
        $get_status = DB::table("lro_status")->select(DB::raw("status_name as text, status_name as value"))->get();
        $status_list = [];
        if($get_status){
            foreach ($get_status as $key => $row){
                $status_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $status_list;
    }

    public function getDocumentType(){
        $get_type = DB::table("document_type")->select(DB::raw("document_type as text, document_type as value"))->get();
        $type_list = [];
        if($get_type){
            foreach ($get_type as $key => $row){
                $type_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $type_list;
    }

    public function getDocumentOwner(){
        $get_owner = DB::table("document_owner")->select(DB::raw("document_owner as text, document_owner as value"))->get();
        $owner_list = [];
        if($get_owner){
            foreach ($get_owner as $key => $row){
                $owner_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $owner_list;
    }

    public function getCategories(){
        $get_categories = DB::table("categories")->select(DB::raw("category as text, category as value"))->orderBy("seq")->get();
        $category_list = [];
        if($get_categories){
            foreach ($get_categories as $key => $row){
                $category_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $category_list;
    }

    public function getIndicatorStatus(){
        $get_status = DB::table("indicator_status")->select(DB::raw("indicator_status as text, indicator_status as value"))->get();
        $status_list = [];
        if($get_status){
            foreach ($get_status as $key => $row){
                $status_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $status_list;
    }

    public function getFrequencies(){
        $get_frequencies = DB::table("frequencies")->select(DB::raw("frequency as text, frequency as value"))->get();
        $frequency_list = [];
        if($get_frequencies){
            foreach ($get_frequencies as $key => $row){
                $frequency_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $frequency_list;
    }

    public function getIndicatorType(){
        $get_type = DB::table("indicator_type")->select(DB::raw("indicator_type as text, indicator_type as value"))->get();
        $type_list = [];
        if($get_type){
            foreach ($get_type as $key => $row){
                $type_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $type_list;
    }

    public function getParticipants(){
        $get_participant = DB::table("participant_profile")->select(DB::raw("participant_name as text, participant_id as value"))->get();
        $participant_list = [];
        if($get_participant){
            foreach ($get_participant as $key => $row){
                $participant_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $participant_list;
    }

    public function getCourses(){
        $get_course = DB::table("courses")->select(DB::raw("course_name as text, course_id as value"))->get();
        $course_list = [];
        if($get_course){
            foreach ($get_course as $key => $row){
                $course_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $course_list;
    }


    public function exportExcel(Request $request){
        $tableName = $request['tableName'];
        $fileName = $tableName.'.xlsx';
        $dataExport = "";

        // Get the role of the user and check if export is ok  
        // $dataExport = DB::table("roles")->select("*")->get(); 
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $roles_id = DB::table('users')->where('id',$userId )->value('roles_id');
        $roles_permission = DB::table('roles_permission')->where('roles_id',$roles_id)->get()->toArray();


        // LSM sub modules
        $is_lsm = false;  
        if(  $tableName == 'Training Attendees' ||  $tableName == 'Courses'  ||  $tableName == 'Participants Profile'){
            $is_lsm = true ;
        }

        foreach ( $roles_permission as $key => $row){
            if( $row->module == $tableName  || ($is_lsm && $row->module =='LMS') ){
                $crud_guard  = DB::table('crud_guard')->where('roles_permission_id',$row->id)->get();
                if( $crud_guard[0]->export == 0 )
                    return  response()->json(  "User not allowed", 401);
                break; 
            }

            
        }

        

        switch ($tableName){
            case "CSOIndicator":
                $dataExport = DB::table("cso_indicator")->select(
                        DB::raw("cso_indicator.cso_category AS Category"),
                        DB::raw("cso_indicator.cso_act_no AS ActivityNo"),
                        DB::raw("cso_indicator.cso_description AS Description"),
                        DB::raw("cso_indicator.cso_status AS Status"),
                        DB::raw("indicator.indicator_no AS 'Indicator No'"),
                        DB::raw("indicator.indicator AS Indicator"),
                        DB::raw("indicator.indicator_type AS Type"),
                        DB::raw("indicator.data_source AS 'Data Source'"),
                        DB::raw("indicator.frequency AS Frequency"),
                        DB::raw("indicator.unit_measure AS 'Unit of Measure'"),
                        DB::raw("indicator.ppr AS PPR"),
                        DB::raw("indicator.baseline_date AS 'Baseline Date'"),
                        DB::raw("indicator.baseline_value AS 'Baseline Value'"),
                        DB::raw("indicator.target_date AS 'Target Date'"),
                        DB::raw("indicator.target_value AS 'Target Value'"),
                        DB::raw("indicator.actual_date AS 'Actual Date'"),
                        DB::raw("indicator.mov_file AS MOV")
                    )
                    ->leftJoin("indicator","cso_indicator.cso_indicator_id", "indicator.cso_indicator_id")
                    ->whereRaw("cso_indicator.deleted_at IS NULL")
                    ->whereRaw("indicator.deleted_at IS NULL")
                    ->where("cso_indicator.cso_category", $request['category'])
                    ->get();

                break;
            case "CSOProfile":
                $dataExport = DB::table("cso_profile")->select(
                    DB::raw("is_lro AS 'Is LRO'"),
                    DB::raw("proj_area AS 'Project Area'"),
                    DB::raw("cso_name AS 'Full name of the CSO/CSO Network'"),
                    DB::raw("cso_type AS 'Type of CSO/CSO Network'"),
                    DB::raw("cso_abbreviation AS 'Abbreviation'"),
                    DB::raw("cso_address AS 'Address'"),
                    DB::raw("cso_phone AS 'Telephone'"),
                    DB::raw("cso_mobile AS 'Mobile Number'"),
                    DB::raw("cso_email AS 'Email Address'"),
                    DB::raw("cso_website AS 'Website/Url'"),
                    DB::raw("cso_facebook AS 'Facebook Account'"),
                    DB::raw("cso_twitter AS 'Twitter Account'"),
                    DB::raw("cso_instagram AS 'Instagram Account'"),
                    DB::raw("cso_youtube AS 'Youtube Account'"),
                    DB::raw("cso_socmed AS 'Other Social Media Account'")
                )
                ->whereRaw("deleted_at IS NULL")
                ->get();
                break;
            case "FinanceTracker":
                $dataExport = DB::table("finance")->select(
                    DB::raw("finance_code,
                                finance_name,
                                finance_location,
                                finance_cost_center,
                                finance_project_code,
                                finance_sof,
                                finance_dea,
                                finance_partner,
                                finance_budget,
                                finance_tranche1,
                                finance_tranche2,
                                finance_tranche3,
                                finance_tranche4,
                                finance_retention,
                                finance_total,
                                finance_actuals,
                                finance_variance,
                                finance_burn1,
                                finance_burn2,
                                finance_burn3,
                                finance_burn4,
                                finance_burn_rate")
                )->whereRaw("deleted_at IS NULL")->get();
                break;
            case "Assessment":
                    $dataExport = DB::table("lro_assessment")->select(
                        DB::raw("cso_profile.cso_name,lro_assessment.domain"),
                        DB::raw(
                            "lro_assessment.tool_used,
                            lro_assessment.conducted_by,
                            lro_assessment.created_at,
                            lro_assessment.final_score,
                            lro_assessment.mov,
                            lro_assessment.status,
                            lro_assessment.created_by,
                            lro_assessment.updated_at,
                            lro_assessment.updated_by
                            ")
                    )
                    ->leftJoin('cso_profile','cso_profile_id','lro_id')
                    ->whereRaw(DB::raw("lro_assessment.deleted_at IS NULL"))
                    ->whereRaw(DB::raw("cso_profile.deleted_at IS NULL"))->get();
                    break;
            case "ProjectTrackingDocuments":
                break;
            case "Participants Profile":
                /*
                "PARTICIPANT ID",
                "PARTICIPANT NAME",
                "PARTICIPANT LOCATION",
                "NAME OF LRO",
                "PARTICIPANT SKILLS"
                */
                    $dataExport = DB::table("participant_profile")->select(
                        DB::raw("
                        participant_profile.participant_id,
                        participant_profile.participant_name, 
                        participant_profile.participant_location,
                        participant_profile.participant_address,
                        cso_profile.cso_name,
                        participant_profile.participant_skills,
                        participant_profile.participant_position,
                        participant_profile.participant_gender,
                        participant_profile.participant_age,
                        participant_profile.created_at,
                        participant_profile.created_by,
                        participant_profile.updated_at,
                        participant_profile.updated_by
                        ")
                    )
                    ->leftJoin('cso_profile','cso_profile_id','lro_id')
                    ->whereRaw(DB::raw("participant_profile.deleted_at IS NULL"))
                    ->whereRaw(DB::raw("cso_profile.deleted_at IS NULL"))->get();        
                break;
            case "Courses":
                $dataExport = DB::table("courses")->select(
                    DB::raw("course_id,
                    course_name,
                    project_area,
                    number_of_modules,
                    developed_by,
                    created_at,
                    created_by,
                    updated_at,
                    updated_by")
                )->whereRaw("deleted_at IS NULL")->get();
            break; 
            case "Training Attendees":
                $dataExport = DB::table("training_attendees")
                ->select(
                    DB::raw("
                        training_attendees.training_id,
                        training_attendees.participant_id,
                        participant_profile.participant_name"
                    ),
                    DB::raw(
                        "courses.course_name,
                        courses.project_area"
                    ),
                    DB::raw(
                        "training_attendees.date_started,
                        training_attendees.date_completed,
                        training_attendees.training_mode,
                        training_attendees.no_hrs,
                        training_attendees.conducted_by,
                        training_attendees.venue,
                        training_attendees.created_at,
                        training_attendees.created_by,
                        training_attendees.updated_at,
                        training_attendees.updated_by"
                        )
                )
                ->leftJoin('participant_profile','participant_profile.participant_id','training_attendees.participant_id')
                ->leftJoin('courses','courses.course_id','training_attendees.course_id')
                ->whereRaw(DB::raw("participant_profile.deleted_at IS NULL"))
                ->whereRaw(DB::raw("training_attendees.deleted_at IS NULL"))
                ->whereRaw(DB::raw("courses.deleted_at IS NULL"))->get();
            break; 
        }

        return Excel::download( (new csoExport)->forTableName($tableName)->forDataExport($dataExport),  $fileName);
    }
}
