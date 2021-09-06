<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LMSController extends Controller
{
    public function getParticipantsProfile(){
        $get_profile = DB::table("participant_profile")
            ->select(
                DB::raw("participant_profile.*"),
                DB::raw("cso_profile.cso_name, cso_profile.proj_area")
            )
            ->leftJoin('cso_profile','cso_profile_id','lro_id')
            ->whereRaw(DB::raw("participant_profile.deleted_at IS NULL"))
            ->whereRaw(DB::raw("cso_profile.deleted_at IS NULL"))->get();
        $profile_list = [];
        if($get_profile){
            foreach ($get_profile as $key => $row){
                $profile_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $profile_list;
    }

    public function saveParticipantsProfile(Request $request){
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $data_array = array();
        $data_array['participant_name'] = $raw_data->participant_name;
        $data_array['participant_location'] = $raw_data->participant_location;
        $data_array['participant_address'] = $raw_data->participant_address;
        $data_array['participant_position'] = $raw_data->participant_position;
        if($raw_data->participant_age!='') {
            $data_array['participant_age'] = $raw_data->participant_gender;
        }
        $data_array['lro_id'] = $raw_data->lro_id;
        $data_array['participant_gender'] = $raw_data->participant_gender;
        $data_array['participant_skills'] = $raw_data->participant_skills;
        $data_array['participant_name'] = $raw_data->participant_name;
        $data_array['participant_name'] = $raw_data->participant_name;
        if($form_mode < 0) {
            $data_array['created_by'] = $user_name;
            $insertData = DB::table('participant_profile')->insert($data_array);
            if($insertData) $success=true;
        }else{
            $data_array['updated_at'] = date("Y-m-d h:i:s");
            $data_array['updated_by'] = $user_name;
            $data_array['participant_age'] = $raw_data->participant_age;
            $updateData = DB::table('participant_profile')->where('participant_id',$raw_data->participant_id)
                ->update($data_array);
            if($updateData) $success=true;
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteParticipantsProfile(Request $request){
        $ID = $request['delete_id'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('participant_profile')->where('participant_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function getCourses(){
        $get_courses = DB::table("courses")
            ->whereRaw(DB::raw("deleted_at IS NULL"))
            ->orderBy("course_name")
            ->get();
        $course_list = [];
        if($get_courses){
            foreach ($get_courses as $key => $row){
                $course_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $course_list;
    }

    public function saveCourses(Request $request){
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $data_array = array();
        $data_array['course_name'] = $raw_data->course_name;
        $data_array['project_area'] = $raw_data->project_area;
        $data_array['number_of_modules'] = $raw_data->number_of_modules;
        $data_array['developed_by'] = $raw_data->developed_by;
        if($form_mode < 0) {
            $data_array['created_by'] = $user_name;
            $insertData = DB::table('courses')->insert($data_array);
            if($insertData) $success=true;
        }else{
            $data_array['updated_at'] = date("Y-m-d h:i:s");
            $data_array['updated_by'] = $user_name;
            $updateData = DB::table('courses')->where('course_id',$raw_data->course_id)
                ->update($data_array);
            if($updateData) $success=true;
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteCourses(Request $request){
        $ID = $request['delete_id'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('courses')->where('course_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function getTrainingAttendees(){
        $get_attendees = DB::table("training_attendees")
            ->select(
                DB::raw("training_attendees.*"),
                DB::raw("participant_profile.participant_name"),
                DB::raw("courses.course_name, courses.project_area")
            )
            ->leftJoin('participant_profile','participant_profile.participant_id','training_attendees.participant_id')
            ->leftJoin('courses','courses.course_id','training_attendees.course_id')
            ->whereRaw(DB::raw("participant_profile.deleted_at IS NULL"))
            ->whereRaw(DB::raw("training_attendees.deleted_at IS NULL"))
            ->whereRaw(DB::raw("courses.deleted_at IS NULL"))->get();
        $attendees_list = [];
        if($get_attendees){
            foreach ($get_attendees as $key => $row){
                $attendees_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $attendees_list;
    }

    public function saveTrainingAttendees(Request $request){
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $data_array = array();
        $data_array['participant_id'] = $raw_data->participant_id;
        $data_array['course_id'] = $raw_data->course_id;
        $data_array['date_started'] = $raw_data->date_started;
        $data_array['date_completed'] = $raw_data->date_completed;
        $data_array['training_mode'] = $raw_data->training_mode;
        $data_array['no_hrs'] = $raw_data->no_hrs;
        $data_array['conducted_by'] = $raw_data->conducted_by;
        $data_array['venue'] = $raw_data->venue;
        if($form_mode < 0) {
            $data_array['created_by'] = $user_name;
            $insertData = DB::table('training_attendees')->insert($data_array);
            if($insertData) $success=true;
        }else{
            $data_array['updated_at'] = date("Y-m-d h:i:s");
            $data_array['updated_by'] = $user_name;
            $updateData = DB::table('training_attendees')->where('training_id',$raw_data->training_id)
                ->update($data_array);
            if($updateData) $success=true;
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteTrainingAttendees(Request $request){
        $ID = $request['delete_id'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('training_attendees')->where('training_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }
}

