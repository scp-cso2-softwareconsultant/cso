<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function getCSONameList(){
        $get_profile = DB::table("cso_profile")
                        ->select(DB::raw("cso_profile_id as value, cso_name as text"))
                        ->where("is_lro", "Yes")->get();
        $cso_profile = [];
        if($get_profile)
            foreach ($get_profile as $key => $row)
                $cso_profile[$key] = json_decode(json_encode($row), true);
        return $cso_profile;
    }

    public function saveCSOProfile(Request $request){
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        if($form_mode < 0) {
            $insertData = DB::table('cso_profile')->insert([
                'is_lro' => $raw_data->is_lro,
                'proj_area' => $raw_data->proj_area,
                'cso_name' => $raw_data->cso_name,
                'cso_type' => $raw_data->cso_type,
                'cso_abbreviation' => $raw_data->cso_abbreviation,
                'cso_address' => $raw_data->cso_address,
                'cso_phone' => $raw_data->cso_phone,
                'cso_mobile' => $raw_data->cso_mobile,
                'cso_email' => $raw_data->cso_email,
                'cso_website' => $raw_data->cso_website,
                'cso_facebook' => $raw_data->cso_facebook,
                'cso_twitter' => $raw_data->cso_twitter,
                'cso_instagram' => $raw_data->cso_instagram,
                'cso_youtube' => $raw_data->cso_youtube,
                'cso_socmed' => $raw_data->cso_socmed,
                'cso_head_name' => $raw_data->cso_head_name,
                'cso_head_email' => $raw_data->cso_head_email,
                'cso_head_number' => $raw_data->cso_head_number,
                'cso_year' => $raw_data->cso_year,
                'cso_registration' => $raw_data->cso_registration,
                'cso_description' => $raw_data->cso_description,
                'cso_beneficiaries' => $raw_data->cso_beneficiaries,
                'cso_stakeholders' => $raw_data->cso_stakeholders,
                'cso_cause' => $raw_data->cso_cause,
                'cso_membership_local' => $raw_data->cso_membership_local,
                'cso_membership_govt' => $raw_data->cso_membership_govt,
                'cso_areas_precovid' => $raw_data->cso_areas_precovid,
                'cso_areas_covid' => $raw_data->cso_areas_covid,
                'cso_support' => $raw_data->cso_support,
                'cso_rsupport_type' => $raw_data->cso_rsupport_type,
                'cso_rsupport_level' => $raw_data->cso_rsupport_level,
                'cso_rsupport_changed' => $raw_data->cso_rsupport_changed,
                'cso_rsupport_changed_why' => $raw_data->cso_rsupport_changed_why,
                'cso_psupport' => $raw_data->cso_psupport,
                'cso_psupport_type' => $raw_data->cso_psupport_type,
                'cso_psupport_level' => $raw_data->cso_psupport_level,
                'cso_psupport_private' => $raw_data->cso_psupport_private,
                'cso_psupport_private_type' => $raw_data->cso_psupport_private_type,
                'cso_psupport_private_level' => $raw_data->cso_psupport_private_level,
                'created_by' => $user_name
            ]);
            if($insertData) $success=true;
        }else{
            $updateData = DB::table('cso_profile')->where('cso_profile_id',$raw_data->cso_profile_id)
                ->update(array(
                    'is_lro' => $raw_data->is_lro,
                    'proj_area' => $raw_data->proj_area,
                    'cso_name' => $raw_data->cso_name,
                    'cso_type' => $raw_data->cso_type,
                    'cso_abbreviation' => $raw_data->cso_abbreviation,
                    'cso_address' => $raw_data->cso_address,
                    'cso_phone' => $raw_data->cso_phone,
                    'cso_mobile' => $raw_data->cso_mobile,
                    'cso_email' => $raw_data->cso_email,
                    'cso_website' => $raw_data->cso_website,
                    'cso_facebook' => $raw_data->cso_facebook,
                    'cso_twitter' => $raw_data->cso_twitter,
                    'cso_instagram' => $raw_data->cso_instagram,
                    'cso_youtube' => $raw_data->cso_youtube,
                    'cso_socmed' => $raw_data->cso_socmed,
                    'cso_head_name' => $raw_data->cso_head_name,
                    'cso_head_email' => $raw_data->cso_head_email,
                    'cso_head_number' => $raw_data->cso_head_number,
                    'cso_year' => $raw_data->cso_year,
                    'cso_registration' => $raw_data->cso_registration,
                    'cso_description' => $raw_data->cso_description,
                    'cso_beneficiaries' => $raw_data->cso_beneficiaries,
                    'cso_stakeholders' => $raw_data->cso_stakeholders,
                    'cso_cause' => $raw_data->cso_cause,
                    'cso_membership_local' => $raw_data->cso_membership_local,
                    'cso_membership_govt' => $raw_data->cso_membership_govt,
                    'cso_areas_precovid' => $raw_data->cso_areas_precovid,
                    'cso_areas_covid' => $raw_data->cso_areas_covid,
                    'cso_support' => $raw_data->cso_support,
                    'cso_rsupport_type' => $raw_data->cso_rsupport_type,
                    'cso_rsupport_level' => $raw_data->cso_rsupport_level,
                    'cso_rsupport_changed' => $raw_data->cso_rsupport_changed,
                    'cso_rsupport_changed_why' => $raw_data->cso_rsupport_changed_why,
                    'cso_psupport' => $raw_data->cso_psupport,
                    'cso_psupport_type' => $raw_data->cso_psupport_type,
                    'cso_psupport_level' => $raw_data->cso_psupport_level,
                    'cso_psupport_private' => $raw_data->cso_psupport_private,
                    'cso_psupport_private_type' => $raw_data->cso_psupport_private_type,
                    'cso_psupport_private_level' => $raw_data->cso_psupport_private_level,
                    'updated_at' => date("Y-m-d h:i:s"),
                    'updated_by' => $user_name
                ));
            if($updateData) $success=true;
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteCSOProfile(Request $request){
        $ID = $request['delete_id'];
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
}
