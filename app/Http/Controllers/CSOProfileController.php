<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

class CSOProfileController extends Controller
{
    public function getCSOProfile(){
        $get_profile = DB::table("cso_profile")->whereRaw(DB::raw("deleted_at IS NULL"))->get();;
        $cso_profile = [];
        if($get_profile)
            foreach ($get_profile as $key => $row)
                $cso_profile[$key] = json_decode(json_encode($row), true);
        return $cso_profile;
    }

    public function saveThematicAreaIfNotExist($given_area){
        $result = DB::table("thematic_areas")
        ->select("thematic_area")
        ->where("thematic_area",$given_area)
        ->get();

        $user = Auth::user();

        if($result->isEmpty())
            DB::table('thematic_areas')
            ->insert([
                "thematic_area"=>$given_area
            ]);
    }

    public function saveCoreServiceIfNotExist($given_core_service){
        $result = DB::table("core_services")
        ->select("core_service")
        ->where("core_service",$given_core_service)
        ->get();

        $user = Auth::user();

        if($result->isEmpty())
            DB::table('core_services')
            ->insert([
                "core_service"=>$given_core_service
            ]);
    }

    public function getCSONameList(){
        $get_profile = DB::table("cso_profile")
                        ->select(DB::raw("cso_id as value, cso_name as text"))
                        ->where("is_lro", "Yes")
                        ->whereRaw(DB::raw("deleted_at IS NULL"))->get();
        $cso_profile = [];
        if($get_profile)
            foreach ($get_profile as $key => $row)
                $cso_profile[$key] = json_decode(json_encode($row), true);
        return $cso_profile;
    }

    public function checkNoExistCSOProfileID(Request $request){

        Log::Info('REQ');

        $get_profile_ids = DB::table("cso_profile")
            ->select('cso_id')
            ->where('cso_id',$request['cso_id'])
            ->whereRaw(DB::raw("deleted_at IS NULL"))
            ->get();
        //Log::info("CHECK MATCH ACT #");
        //Log::info($request['cso_id']);
        //Log::info($request['category']);
        //Log::info("-----------------");

        return $get_profile_ids;
    }

    public function getAvailableCSOID(){
        $available_id = DB::table("cso_profile")->select('cso_id')->whereRaw(DB::raw("deleted_at IS NULL"))->get();
        $counter = 0;

        foreach($available_id as $r){
            $counter = $r->cso_id;
        }

        if($counter == 0) return 1;
        return $counter+1;
    }

    public function saveCSOProfile(Request $request){
        $cso_ID = $this->getAvailableCSOID();
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        if($form_mode < 0) {
            $insertData = DB::table('cso_profile')->insert([
                
                'cso_id' => $cso_ID,
                "cso_year" => $raw_data->cso_year,
                "cso_sec_registration_no" => $raw_data->cso_sec_registration_no,
                "cso_registration" => $raw_data->cso_registration,
                "cso_description" => $raw_data->cso_description,
                "cso_core_service" => $raw_data->cso_core_service,
                "cso_thematic_areas" => $raw_data->cso_thematic_areas,
                "cso_beneficiaries" => $raw_data->cso_beneficiaries,
                "cso_membership_non_government" => $raw_data->cso_membership_non_government,
                "cso_membership_government" => $raw_data->cso_membership_government,
                "cso_current_donors" => $raw_data->cso_current_donors,
                "cso_size_funding_portfolio" => $raw_data->cso_size_funding_portfolio,
                "cso_number_staff" => $raw_data->cso_number_staff,
                "cso_number_networ_members" => $raw_data->cso_number_networ_members,
                "cso_stakeholders" => $raw_data->cso_stakeholders,
                "is_lro" => $raw_data->is_lro,
                "type_of_support" => $raw_data->type_of_support,
                "cso_name" => $raw_data->cso_name,
                "cso_type" => $raw_data->cso_type,
                'created_by' => $user_name
            ]);
            if($insertData) $success=true;
        }else{
            //Log::info('SAVING UPDATE');
            //Log::info($raw_data -> cso_id);
            $updateData = DB::table('cso_profile')->where('cso_profile_id',$raw_data->cso_profile_id)
                ->update(array(
                    'cso_id' => $raw_data -> cso_id,
                    
                    "cso_year" => $raw_data->cso_year,
                    "cso_sec_registration_no" => $raw_data->cso_sec_registration_no,
                    "cso_registration" => $raw_data->cso_registration,
                    "cso_description" => $raw_data->cso_description,
                    "cso_core_service" => $raw_data->cso_core_service,
                    "cso_thematic_areas" => $raw_data->cso_thematic_areas,
                    "cso_beneficiaries" => $raw_data->cso_beneficiaries,
                    "cso_membership_non_government" => $raw_data->cso_membership_non_government,
                    "cso_membership_government" => $raw_data->cso_membership_government,
                    "cso_current_donors" => $raw_data->cso_current_donors,
                    "cso_size_funding_portfolio" => $raw_data->cso_size_funding_portfolio,
                    "cso_number_staff" => $raw_data->cso_number_staff,
                    "cso_number_networ_members" => $raw_data->cso_number_networ_members,
                    "cso_stakeholders" => $raw_data->cso_stakeholders,
                    "is_lro" => $raw_data->is_lro,
                    "type_of_support" => $raw_data->type_of_support,
                    "cso_name" => $raw_data->cso_name,
                    "cso_type" => $raw_data->cso_type,
                    'updated_at' => date("Y-m-d h:i:s"),
                    'updated_by' => $user_name
                ));
            if($updateData){
                $success=true;
                foreach ($raw_data->cso_iterable_thematic_area as $key => $row)
                    $this->saveThematicAreaIfNotExist($row);
                foreach ($raw_data->cso_iterable_core_services as $key => $row)
                    $this->saveCoreServiceIfNotExist($row);
            }
        }
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteCSOProfile(Request $request){
        $ID = $request['delete_id'];
        // Log::info("DELETE REQ");
        // LOG::info($request['delete_id']);
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('cso_profile')->where('cso_profile_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }
    public function getTypesOfSupport(Request $request){
        $data_arr = DB::table("type_of_support")->get();
        return response()->json($data_arr, 200);
    }
}
