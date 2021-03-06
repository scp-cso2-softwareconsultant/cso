<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Log;
class LROAssessmentController extends Controller
{

    public function downloadMov(Request $request){
        $file_name = $request['file_name'];
        $path= Storage::disk('public')->path("lro_assessment/$request->file_name");
        $content = file_get_contents($path);
        return response($content)->withHeaders([
            'Content-Type'=>mime_content_type($path),
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment;filename='.$file_name
        ]);
    }

    public function downloadAssessSubAttach(Request $request){
        $file_name = $request['file_name'];
        $path= Storage::disk('public')->path("lro_assessment/sub/$request->file_name");
        $content = file_get_contents($path);
        return response($content)->withHeaders([
            'Content-Type'=>mime_content_type($path),
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment;filename='.$file_name
        ]);
    }

    public function getLROAssessment(){
        $get_lro = DB::table("lro_assessment")
            ->select(
                DB::raw("lro_assessment.*"),
                DB::raw("cso_profile.cso_name as cso_name")
            )
            ->leftJoin('cso_profile','cso_profile.cso_profile_id','lro_assessment.lro_name')
            ->whereRaw(DB::raw("lro_assessment.deleted_at IS NULL"))
            ->whereRaw(DB::raw("cso_profile.deleted_at IS NULL"))->get();
        $lro_list = [];
        if($get_lro){
            foreach ($get_lro as $key => $row){
                $lro_list[$key] = json_decode(json_encode($row), true);
                $get_sub = DB::table("lro_assessment_sub")->where("lro_assessment_id", $row->lro_assessment_id)->whereRaw(DB::raw("deleted_at IS NULL"))->get();
                $lro_sub = [];
                if($get_sub){
                    foreach ($get_sub as $dKey => $dRow){
                        $lro_sub[$dKey] = json_decode(json_encode($dRow), true);
                    }
                    $lro_list[$key]['subItems'] = $lro_sub;
                }

                $lro_list[$key]['rating_tool'] = $this->getRating($row->tool_used);
            }
        }

        return $lro_list;
    }

    public function getRating($tool_used){
        $get_rating = DB::table("lro_rating")->select(DB::raw("rating_label as text, rating_id as value"))
            ->where("rating_tool",$tool_used)->get();
        $rating_list = [];
        if($get_rating){
            foreach ($get_rating as $key => $row){
                $rating_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $rating_list;
    }

    public function saveLROAssessment(Request $request){
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $data_array = array();
        $data_array['lro_name'] = $raw_data->lro_name;
        
        //$data_array['domain'] = $raw_data->domain;
        if($raw_data->final_score >= 0) {$data_array['final_score'] = $raw_data->final_score;}
        $data_array['conducted_by'] = $raw_data->conducted_by;
        $data_array['tool_used'] = $raw_data->tool_used;
        $data_array['assessment_date'] = ($raw_data->assessment_date != '') ? $raw_data->assessment_date : NULL;
        $data_array['org_address'] = $raw_data->org_address;
        //$lro_ID = DB::table('users')->where('id',$userId )->value('roles_id')

        if($request->hasFile('upload_file')){
            $file_size = filesize($request->file('upload_file'));
            // Get filename with the extension
            $filenameWithExt = $request->file('upload_file')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('upload_file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.uniqid().'.'.$extension;
            // Upload Image
            $path = $request->file('upload_file')->storeAs('public/lro_assessment',$fileNameToStore);
            $data_array['mov'] = $fileNameToStore;
        }

        if($form_mode < 0) {
            

            $data_array['status'] = 'Entry';
            $data_array['created_by'] = $user_name;
            $insertData = DB::table('lro_assessment')->insert($data_array);
            if($insertData) $success=true;
        }else{
            

            if($request['delete_attachedFile'])
                $this-> deleteAssessmentMov($request);

            $data_array['status'] = $raw_data->status;
            $data_array['updated_at'] = date("Y-m-d h:i:s");
            $data_array['updated_by'] = $user_name;
            $updateData = DB::table('lro_assessment')->where('lro_assessment_id',$raw_data->lro_assessment_id)
                ->update($data_array);
            if($updateData) $success=true;
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteLROAssessment(Request $request){
        $ID = $request['delete_id'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('lro_assessment')->where('lro_assessment_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }


    public function saveLROAssessmentSub(Request $request){
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $data_array = array();
        $data_array['lro_assessment_id'] = $raw_data->lro_assessment_id;
        $data_array['sub_domain'] = $raw_data->sub_domain;
        $data_array['rating'] = $raw_data->rating;
        $data_array['remarks'] = $raw_data->remarks;

        if($request->hasFile('upload_file')){
            $file_size = filesize($request->file('upload_file'));
            // Get filename with the extension
            $filenameWithExt = $request->file('upload_file')->getClientOriginalName();
            //Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $request->file('upload_file')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.uniqid().'.'.$extension;
            // Upload Image
            $path = $request->file('upload_file')->storeAs('public/lro_assessment/sub',$fileNameToStore);
            $data_array['file_attachment'] = $fileNameToStore;
        }

        if($form_mode < 0) {
            $data_array['created_by'] = $user_name;
            $insertData = DB::table('lro_assessment_sub')->insert($data_array);
            if($insertData) $success=true;
        }else{
            $data_array['updated_at'] = date("Y-m-d h:i:s");
            $data_array['updated_by'] = $user_name;

            if($request['delete_attachedFile'])
                $this-> deleteAssessmentSubFileAttachment($request);
        
            $updateData = DB::table('lro_assessment_sub')->where('lro_sub_id',$raw_data->lro_sub_id)
                ->update($data_array);
            if($updateData) $success=true;
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteAssessmentSubFileAttachment(Request $request){
        $raw_data = json_decode($request['data']);
        $deletion = DB::table('lro_assessment_sub')->where('lro_sub_id',$raw_data->lro_sub_id)->update(["file_attachment" => '']);
    }

    public function deleteAssessmentMov(Request $request){
        $raw_data = json_decode($request['data']);
        $deletion = DB::table('lro_assessment')->where('lro_assessment_id',$raw_data->lro_assessment_id)->update(["mov" => '']);
    }

    public function deleteLROAssessmenSub(Request $request){
        $ID = $request['delete_id'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('lro_assessment_sub')->where('lro_sub_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }
}

