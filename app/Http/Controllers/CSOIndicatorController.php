<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CSOIndicatorController extends Controller
{
    public function index()
    {
        return $this->getCSOIndicator();
        return User::all();
    }

    public function getCSOIndicator(){

        $get_category = DB::table("categories")->where("seq",1)->first();
        $category = "Activity";
        if($get_category){
            $category = $get_category->category;
        }
        $get_indicator = DB::table("cso_indicator")
            ->where("cso_category",$category)
            ->whereRaw(DB::raw("deleted_at IS NULL"))
            ->get();
        $cso_indicator = [];
        if($get_indicator){
            foreach ($get_indicator as $key => $row){
                $cso_indicator[$key] = json_decode(json_encode($row), true);
                $get_details = DB::table("indicator")->where("cso_indicator_id", $row->cso_indicator_id)
                    ->whereRaw(DB::raw("deleted_at IS NULL"))
                    ->get();
                $cso_details = [];
                if($get_details){
                    foreach ($get_details as $dKey => $dRow){
                        $cso_details[$dKey] = json_decode(json_encode($dRow), true);
                    }
                    $cso_indicator[$key]['subItems'] = $cso_details;
                }
            }
        }

        return $cso_indicator;
    }

    public function getCSOIndicatorList(Request $request){
        $get_indicator = DB::table("cso_indicator")
            ->where("cso_category",$request['category'])
            ->whereRaw(DB::raw("deleted_at IS NULL"))
            ->whereRaw("cso_status != 'Cancelled'")
            ->get();
        $cso_indicator = [];
        if($get_indicator){
            foreach ($get_indicator as $key => $row){
                $cso_indicator[$key] = json_decode(json_encode($row), true);
                $get_details = DB::table("indicator")
                    ->where("cso_indicator_id", $row->cso_indicator_id)
                    ->whereRaw("deleted_at IS NULL")
                    ->orderBy("indicator_no")
                    ->get();
                $cso_details = [];
                if($get_details){
                    foreach ($get_details as $dKey => $dRow){
                        $cso_details[$dKey] = json_decode(json_encode($dRow), true);
                    }
                    $cso_indicator[$key]['subItems'] = $cso_details;
                }
            }
        }

        return $cso_indicator;
    }

    public function saveCSOIndicator(Request $request){

        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        if($form_mode < 0) {
            $insertData = DB::table('cso_indicator')->insert([
                'cso_category' => $raw_data->cso_category,
                'cso_description' => $raw_data->cso_description,
                'cso_status' => 'Entry',
                'created_by' => $user_name
            ]);
            if($insertData) $success=true;
        }else{
            $updateData = DB::table('cso_indicator')->where('cso_indicator_id',$raw_data->cso_indicator_id)
                ->update(array(
                    'cso_category' => $raw_data->cso_category,
                    'cso_description' => $raw_data->cso_description,
                    'cso_status' => $raw_data->cso_status,
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

    public function saveCSOIndicatorDetails(Request $request){
        $_raw_data = json_decode($request['data'], true);
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $cso_id = $request['cso_id'];
        $cso_type = $request['cso_type'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        if($form_mode < 0) {
            $insertData = DB::table('indicator')->insert([
                'cso_indicator_id' => $cso_id,
                'indicator_no' => $raw_data->indicator_no,
                'indicator' => $raw_data->indicator,
                'indicator_type' => $raw_data->indicator_type,
                'data_source' => $raw_data->data_source,
                'frequency' => $raw_data->frequency,
                'unit_measure' => $raw_data->unit_measure,
                'ppr' => $raw_data->ppr,
                'baseline_date' => (key_exists('baseline_date', $_raw_data) ? $raw_data->baseline_date : NULL),
                'baseline_value' => (key_exists('baseline_value', $_raw_data) ? $raw_data->baseline_value : ''),
                'target_date' => (key_exists('target_date', $_raw_data) ? $raw_data->target_date : NULL),
                'target_value' => (key_exists('target_value', $_raw_data) ? $raw_data->target_value : ''),
                'actual_date' => (key_exists('actual_date', $_raw_data) ? $raw_data->actual_date : NULL),
                'indicator_status_id' => 1,
                'created_by' => $user_name,

            ]);
            if($insertData) $success=true;
        }else{
            $updateData = DB::table('indicator')->where('indicator_id',$raw_data->indicator_id)->update(array(
                'indicator_no' => $raw_data->indicator_no,
                'indicator' => $raw_data->indicator,
                'indicator_type' => $raw_data->indicator_type,
                'data_source' => $raw_data->data_source,
                'frequency' => $raw_data->frequency,
                'unit_measure' => $raw_data->unit_measure,
                'ppr' => $raw_data->ppr,
                'baseline_date' => $raw_data->baseline_date,
                'baseline_value' => $raw_data->baseline_value,
                'target_date' => $raw_data->target_date,
                'target_value' => $raw_data->target_value,
                'actual_date' => $raw_data->actual_date,
                'updated_at' => date("Y-m-d h:i:s"),
                'updated_by' => $user_name,
            ));

            if($updateData) $success=true;
        }

        if($request->hasFile('upload_file')){
            $get_cso_category = DB::table('cso_indicator')->where('cso_indicator_id', $raw_data->cso_indicator_id)->first();

            // Get filename with the extension
            $filenameWithExt = $request->file('upload_file')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('upload_file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('upload_file')->storeAs('public/cso_indicators/'.$get_cso_category->cso_category,$fileNameToStore);

            DB::table('indicator')->where('indicator_id',$raw_data->indicator_id)->update(array("mov_file" => $fileNameToStore));
            $this->computeCompletion($raw_data->cso_indicator_id, $get_cso_category->cso_status);
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteCSOIndicator(Request $request){

        $ID = $request['delete_id'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('cso_indicator')->where('cso_indicator_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteCSOIndicatorDetails(Request $request){

        $ID = $request['delete_id'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('indicator')->where('indicator_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function computeCompletion($cso_id,$current_status){
        // count total indicator
        $total_count = 0;
        $total_count = DB::table('indicator')
            ->where("cso_indicator_id", $cso_id)
            ->count();
        // count with actual dates
        $total_complete = 0;
        $cso_count = '';
        $total_complete = DB::table('indicator')
            ->where("cso_indicator_id", $cso_id)
            ->whereRaw(DB::raw("mov_file IS NOT NULL"))
            ->count();
        // compute completion
        $completion = 0;
        if($total_count > 0) {
            $completion = ($total_complete / $total_count) * 100;
        }
        $cso_count = $total_complete . '/' . $total_count;
        $status = '';
        if($completion > 0 && $completion < 100){
            $status =  'In Progress';
        }
        else if($completion == 100){
            $status = 'Completed';
        }
        else {
            $status = 'Entry';
        }
        if($current_status == 'Delayed'){
            $status = 'Delayed';
        }

        DB::table('cso_indicator')->where("cso_indicator_id",$cso_id)
            ->update( array('cso_completion' => $completion, 'cso_status' =>$status, 'cso_count' => $cso_count) );
    }

    public function chartCSOIndicator(Request $request){
       
        return  $request;
    }

}
