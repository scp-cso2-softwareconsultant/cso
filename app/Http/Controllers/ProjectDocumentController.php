<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
class ProjectDocumentController extends Controller
{
    public function getDocument(){
        $get_document = DB::table("document")
            ->whereRaw(DB::raw("document.deleted_at IS NULL"))->get();
        $document_list = [];
        if($get_document){ 
            foreach ($get_document as $key => $row){
                $document_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $document_list;
    }

    public function getProjectTrackingDocument(){
        $project_document = DB::table("project_tracking_document")->get()->first();
        $first =  [$project_document];
        $second = [DB::table("project_tracking_objectives")->select('*')->where('project_tracking_document_id',$project_document->id)->get()];

        $collection = collect($first);
        $merged     = $collection->merge($second);
        $result[]   = $merged->all();


        return $result;
    }

    public function saveProjectTrackingDocument(Request $request ) {
        $raw_data = json_decode($request['data']);
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        
        $document= "";
        if( $user->roles_id == 1 ){
            if(  $raw_data->id ){
                $document = DB::table('project_tracking_document')->where('id',$raw_data->id )->update(array(
                    'donor_report' => $raw_data->donor_report,
                    'actions_or_support' => $raw_data->actions_or_support,
                    'spent_to_date' => $raw_data->spent_to_date,
                ));
            }else{
                $document = DB::table('project_tracking_document')->insert([
                    'donor_report' => $raw_data->donor_report,
                    'actions_or_support' => $raw_data->actions_or_support,
                    'spent_to_date' => $raw_data->spent_to_date,
                ]);
            }
        }

        $objective = "";
        foreach ( $raw_data->objective as $key => $row){
            if( $row->id ){
                $objective = DB::table('project_tracking_objectives')->where('id', $row->id )->update(array(
                    'Implementation_vs_target' => $row->Implementation_vs_target,
                    'Objective' => $row->Objective,
                    'challanges' => $row->challanges,
                    'estimated_progress' => $row->estimated_progress,
                    'indicators' => $row->indicators,
                    'next_month_planning' => $row->next_month_planning,
                    "project_tracking_document_id" =>$raw_data->id 
                ));
               
            }else{
                DB::table('project_tracking_objective')->insert([
                    'Implementation_vs_target' => $row->Implementation_vs_target,
                    'Objective' => $row->Objective,
                    'challanges' => $row->challanges,
                    'estimated_progress' => $row->estimated_progress,
                    'indicators' => $row->indicators,
                    'next_month_planning' => $row->next_month_planning,
                    'project_tracking_document_id'=>$raw_data->id
                ]);
            }
        }
    
        return $document;
    }
    public function saveDocument(Request $request){
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $data_array = array();
        $data_array['document_name'] = $raw_data->document_name;
        $data_array['document_type'] = $raw_data->document_type;
        $data_array['document_description'] = $raw_data->document_description;
        $data_array['document_version'] = $raw_data->document_version;

        $data_array['document_source'] = $raw_data->document_source;
        $data_array['document_owner'] = $raw_data->document_owner;

        $data_array['document_remarks'] = $raw_data->document_remarks;
//        $data_array['document_path'] = $raw_data->document_path;
        $documentID = '';
        if($form_mode < 0) {
            if($request->hasFile('upload_file')){
                $file_size = filesize($request->file('upload_file'));
                // Get filename with the extension
                $filenameWithExt = $request->file('upload_file')->getClientOriginalName();
                //Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('upload_file')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                // Upload Image
                $path = $request->file('upload_file')->storeAs('public/project_tracking_document/'.$raw_data->document_type,$fileNameToStore);
                $data_array['document_date'] = date("Y-m-d");
                $data_array['document_file_size'] = $this->formatSizeUnits($file_size);
                $data_array['document_path'] = $path;
            }
            $data_array['created_by'] = $user_name;
            $insertData = DB::table('document')->insert($data_array);

            if($insertData) $success=true;
        }else{
            $data_array['updated_at'] = date("Y-m-d h:i:s");
            $data_array['updated_by'] = $user_name;
            $data_array['participant_age'] = $raw_data->participant_age;
            $updateData = DB::table('document')->where('document_id',$raw_data->document_id)
                ->update($data_array);
            if($updateData) $success=true;
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteDocument(Request $request){
        $ID = $request['delete_id'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('document')->where('document_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

