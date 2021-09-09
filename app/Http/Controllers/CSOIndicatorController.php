<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;


//delete to later :: for loggin purpose only
use Illuminate\Support\Facades\Log;

class CSOIndicatorController extends Controller
{
    public function index()
    {
        return $this->getCSOIndicator();
        return User::all();
    }

    /**
     * This returns & downloads requested (sub item)MOV File
     *
     * @param Request $request params/data file_name
     * 
     * @author Senpai Dev Team
     * @return file Requested File
     */ 
    public function downloadMov(Request $request){
        Log::info("CALLED DOWNLOAD FILE");
        $file_name = $request['file_name'];
        $path= Storage::disk('public')->path("cso_indicators_mov/$request->category/$request->file_name");
        $content = file_get_contents($path);
        return response($content)->withHeaders([
            'Content-Type'=>mime_content_type($path),
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment;filename='.$file_name
        ]);
    }

    /**
     * This returns & downloads requested CSO MOV file
     *
     * @param Request $request params/data file_name
     * 
     * @author Senpai Dev Team
     * @return file Requested File
     */ 
    public function downloadCSOMov(Request $request){
        Log::info("CALLED DOWNLOAD FILE");
        $file_name = $request['file_name'];
        $path= Storage::disk('public')->path("cso_indicators_mov/output_mov/$request->file_name");
        $content = file_get_contents($path);
        return response($content)->withHeaders([
            'Content-Type'=>mime_content_type($path),
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment;filename='.$file_name
        ]);
    }

    public function checkNoExist(Request $request){
        $get_indicator = DB::table("cso_indicator")
            ->select('cso_act_no')
            ->where('cso_act_no','LIKE','%'.$request['act_no'].'%')
            ->where('cso_category',$request['category'])
            ->whereRaw(DB::raw("deleted_at IS NULL"))
            ->get();
        Log::info("CHECK MATCH ACT #");
        Log::info($request['act_no']);
        Log::info($request['category']);
        Log::info("-----------------");

        return $get_indicator;
    }

    public function checkSuNoExist(Request $request){
        $get_indicator =  DB::table('indicator')->where('cso_indicator_id',$request['cso_indicator_id'])
            ->where('indicator_no','LIKE','%'.$request['indicator_no'].'%')
            ->whereRaw(DB::raw("deleted_at IS NULL"))
            ->get();
        Log::info("CHECK MATCH Sub #");
        Log::info($request['indicator_no']);
        Log::info($request['cso_indicator_id']);
        Log::info("-----------------");

        return $get_indicator;
    }

    /**
     * This returns all data from cso_indicator table with a category of 'Activity' sub data from indicator table
     *
     * @param Request $request params/data
     * 
     * @author Senpai Dev Team
     * @return cso_indicator db result
     */ 
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

    /**
     * This returns all data from cso_indicator table with sub data from indicator table
     *
     * @param Request $request params/data
     * 
     * @author Senpai Dev Team
     * @return cso_indicator db result
     */ 
    public function getCSOIndicatorList(Request $request){
        $get_indicator = DB::table("cso_indicator")
            ->where("cso_category",$request['category'])
            ->whereRaw(DB::raw("deleted_at IS NULL"))
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

    /**
    *
    * Uncomment The function below if client want all data not only activities to be return for dashboard
    *
    * @return      array 
    *
    */
    // public function getCSOIndicatorListDashboard(Request $request){
    //     $get_indicator = DB::table("cso_indicator")
    //         ->whereRaw(DB::raw("deleted_at IS NULL"))
    //         ->get();
    //     $cso_indicator = [];
    //     if($get_indicator){
    //         foreach ($get_indicator as $key => $row){
    //             $cso_indicator[$key] = json_decode(json_encode($row), true);
    //             $get_details = DB::table("indicator")
    //                 ->where("cso_indicator_id", $row->cso_indicator_id)
    //                 ->whereRaw("deleted_at IS NULL")
    //                 ->orderBy("indicator_no")
    //                 ->get();
    //             $cso_details = [];
    //             if($get_details){
    //                 foreach ($get_details as $dKey => $dRow){
    //                     $cso_details[$dKey] = json_decode(json_encode($dRow), true);
    //                 }
    //                 $cso_indicator[$key]['subItems'] = $cso_details;
    //             }
    //         }
    //     }

    //     return $cso_indicator;
    // }


    /**
     * This saves cso new or edited item
     *
     * @param Request $request params/data object
     * 
     * @author Senpai Dev Team
     * @return Status return status code
     */ 
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
                'cso_act_no' => $raw_data->cso_act_no,
                'cso_indicator_mov' => $raw_data->cso_indicator_mov,
                'cso_remarks' => $raw_data->cso_remarks,
                'cso_intermediate_outcome' => $raw_data -> cso_intermediate_outcome,
                'cso_lead_organization' => $raw_data->cso_lead_organization,
                'cso_status' => 'Not Yet Started',
                'created_by' => $user_name
            ]);
            if($insertData) $success=true;
        }else{
            Log::info($request->all());
            $updateData = DB::table('cso_indicator')->where('cso_indicator_id',$raw_data->cso_indicator_id)
                ->update(array(
                    'cso_category' => $raw_data->cso_category,
                    'cso_act_no' => $raw_data->cso_act_no,
                    'cso_status' => $raw_data->cso_status,
                    'cso_indicator_mov'=> $raw_data->cso_indicator_mov,
                    'cso_intermediate_outcome' => $raw_data -> cso_intermediate_outcome,
                    'cso_remarks'=>$raw_data -> cso_remarks,
                    'cso_lead_organization' => $raw_data-> cso_lead_organization,
                    'cso_description' => $raw_data->cso_description,
                    'updated_at' => date("Y-m-d h:i:s"),
                    'updated_by' => $user_name
                ));
            if($updateData) $success=true;
            Log::info("UPDATE DATA");
        }

        if($request->hasFile('upload_file') && $form_mode >= 0){
            Log::info('Theres File Woah!');

            // Get filename with the extension
            $filenameWithExt = $request->file('upload_file')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('upload_file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('upload_file')->storeAs('public/cso_indicators_mov/output_mov',$fileNameToStore);
            DB::table('cso_indicator')->where('cso_indicator_id',$raw_data->cso_indicator_id)->update(array("cso_indicator_mov" => $fileNameToStore));
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

     /**
     * This saves cso new or edited sub item
     *
     * @param Request $request params/data object
     * 
     * @author Senpai Dev Team
     * @return Status return status code
     */ 
    public function saveCSOIndicatorDetails(Request $request){
        $_raw_data = json_decode($request['data'], true);
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $cso_id = $request['cso_id'];
        $cso_type = $request['cso_type'];
        $updateData = false;

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
                'indicator_status' => $raw_data->indicator_status,
                'indicator_remarks' => $raw_data->indicator_remarks,
                'ppr' => $raw_data->ppr,
                'baseline_date' => (key_exists('baseline_date', $_raw_data) ? $raw_data->baseline_date : NULL),
                'baseline_value' => (key_exists('baseline_value', $_raw_data) ? $raw_data->baseline_value : ''),
                'target_date' => (key_exists('target_date', $_raw_data) ? $raw_data->target_date : NULL),
                'target_value' => (key_exists('target_value', $_raw_data) ? $raw_data->target_value : ''),
                'actual_date' => (key_exists('actual_date', $_raw_data) ? $raw_data->actual_date : NULL),
                'indicator_status_id' => 1,
                'created_by' => $user_name,

            ]);
            $this->autoChangeStatus($cso_id);
            if($insertData) $success=true;
        }else{
            $updateData = DB::table('indicator')->where('indicator_id',$raw_data->indicator_id)->update(array(
                'indicator_no' => $raw_data->indicator_no,
                'indicator' => $raw_data->indicator,
                'indicator_type' => $raw_data->indicator_type,
                'data_source' => $raw_data->data_source,
                'frequency' => $raw_data->frequency,
                'unit_measure' => $raw_data->unit_measure,
                'indicator_status' => $raw_data->indicator_status,
                'indicator_remarks' => $raw_data -> indicator_remarks,
                'ppr' => $raw_data->ppr,
                'baseline_date' => $raw_data->baseline_date,
                'baseline_value' => $raw_data->baseline_value,
                'target_date' => $raw_data->target_date,
                'target_value' => $raw_data->target_value,
                'actual_date' => $raw_data->actual_date,
                'updated_at' => date("Y-m-d h:i:s"),
                'updated_by' => $user_name,
            ));

            $getCsoIndicatorId = DB::table('indicator')->select('cso_indicator_id')->where('indicator_id',$raw_data->indicator_id)->get();
            $this->autoChangeStatus($getCsoIndicatorId->first()->cso_indicator_id);
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
            $path = $request->file('upload_file')->storeAs('public/cso_indicators_mov/'.$get_cso_category->cso_category,$fileNameToStore);
            DB::table('indicator')->where('indicator_id',$raw_data->indicator_id)->update(array("mov_file" => $fileNameToStore));
            $this->computeCompletion($raw_data->cso_indicator_id, $get_cso_category->cso_status);
        }
        if($updateData) $success=true;

        $data_arr = [ "success" => $success ];
        return response()->json($data_arr, 200);
    }

     /**
     * This auto update cso indicator table cso status column based on sub item's statuses
     *
     * @param String $string which contains cso_indicator_id
     * 
     * @author Senpai Dev Team
     * @return void return nothing
     */ 
    public function autoChangeStatus($cso_indicator_id){
        $indicators = DB::table('indicator')->where('cso_indicator_id',$cso_indicator_id)->whereNull('deleted_at')
        ->get();

        $isCompleted = true;

        foreach($indicators as $r){
           if($r->indicator_status != 'Completed' && $r->indicator_status != 'Cancelled'){
               $isCompleted = false;
               break;
           }
       }

       if($isCompleted){
            $updateCSO = DB::table('cso_indicator')->where('cso_indicator_id',$cso_indicator_id)
            ->update(array('cso_status' => 'Completed'));
        }
        else{
            $updateCSO = DB::table('cso_indicator')->where('cso_indicator_id',$cso_indicator_id)
            ->update(array('cso_status' => 'In Progress'));
        }
    }

    /**
     * This marks a record from cso_indicator table as deleted
     *
     * @param Request $string which contains delete_id (cso_indicator_id)
     * 
     * @author Senpai Dev Team
     * @return Status return status code
     */ 
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

     /**
     * This marks a record from indicator table as deleted
     *
     * @param Request $string which contains delete_id (indicator_id)
     * 
     * @author Senpai Dev Team
     * @return Status return status code
     */ 
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

    /**
     * This code is from the first dev of this project, i think it's the same 
     * with the autoChangeStatus that we've made, we didn't use this anymore
     * due to changes during client's meeting
     * 
     * @author UNKNOWN
     */ 
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

   

}
