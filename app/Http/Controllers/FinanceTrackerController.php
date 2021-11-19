<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FinanceTrackerController extends Controller
{
    public function getFinanceTracker(){
        $get_ft = DB::table('finance') ->whereRaw(DB::raw("deleted_at IS NULL"))->orderBy('created_by', 'DESC')->get();
        $ft_list = [];
        if($get_ft){
            foreach ($get_ft as $key => $row){
                $ft_list[$key] = json_decode(json_encode($row), true);
            }
        }

        return $ft_list;
    }

    public function saveCSOLeadOrganizationIfNotExist($given_cso){
        $result = DB::table("lead_organization")
        ->select("organization_name")
        ->where("organization_name",$given_cso)
        ->get();

        $user = Auth::user();

        if($result->isEmpty())
            DB::table('lead_organization')
            ->insert([
                "organization_name"=>$given_cso,
                "created_by"=> $user->firstname,
                "created_at"=> date("Y-m-d h:i:s")
            ]);
    }

    public function getFinance($given_cso){
        $finance_tracker = DB::table('finance')
            ->where('finance_name',$given_cso)
            ->whereRaw(DB::raw("deleted_at IS NULL"))
            ->get()
            ->first();
        return $finance_tracker ;
    }


    public function saveFinanceTracker(Request $request){
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;




        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;

        $finance_name = $raw_data->finance_name;

        $finance_budget = $raw_data->finance_budget != '' ? $raw_data->finance_budget : 0;

        $finance_tranche1 = $raw_data->finance_tranche1 != '' ? $raw_data->finance_tranche1 : 0;
        $finance_tranche2 = $raw_data->finance_tranche2 != '' ? $raw_data->finance_tranche2 : 0;
        $finance_tranche3 = $raw_data->finance_tranche3 != '' ? $raw_data->finance_tranche3 : 0;
        $finance_tranche4 = $raw_data->finance_tranche4 != '' ? $raw_data->finance_tranche4 : 0;

        $finance_tranche1_date = ( $raw_data->finance_tranche1_date != '') ? date('Y-m-d',strtotime( $raw_data->finance_tranche1_date ) ): '';
        $finance_tranche2_date = ( $raw_data->finance_tranche2_date != '') ? date('Y-m-d',strtotime( $raw_data->finance_tranche2_date ) ): '';
        $finance_tranche3_date = ( $raw_data->finance_tranche3_date != '') ? date('Y-m-d',strtotime( $raw_data->finance_tranche3_date ) ): '';
        $finance_tranche4_date = ( $raw_data->finance_tranche4_date != '') ? date('Y-m-d',strtotime( $raw_data->finance_tranche4_date ) ): '';

        $finance_retention = $raw_data->finance_retention != ''? $raw_data->finance_retention: 0;
        $finance_actuals = $raw_data->finance_actuals != '' ? $raw_data->finance_actuals : 0;

        $finance = $this->getFinance($finance_name);
        if( $finance != null && $form_mode < 0) {

            $finance_budget += $finance->finance_budget;
            $finance_tranche1 += $finance -> finance_tranche1;
            $finance_tranche2 += $finance -> finance_tranche2;
            $finance_tranche3 += $finance -> finance_tranche3;
            $finance_tranche4 += $finance -> finance_tranche4;
            $finance_retention += $finance -> finance_retention;
            $finance_actuals += $finance -> finance_actuals;

            Log::info( $finance_budget );
        }

        $finance_total = $finance_tranche1 + $finance_tranche2 + $finance_tranche3 + $finance_tranche4 ;
        $finance_variance = $finance_total - $finance_actuals;
        $finance_burn_rate = $finance_actuals / ($finance_tranche1+$finance_tranche2+$finance_tranche3+$finance_tranche4+$finance_retention)* 100; 

        $this->saveCSOLeadOrganizationIfNotExist($finance_name);
        
        


        if($form_mode < 0 && $finance == null) {
            $insertData = DB::table('finance')->insert([
                'finance_name' => $finance_name,
                'finance_budget' => $finance_budget,
                'finance_tranche1' => $finance_tranche1,
                'finance_tranche2' => $finance_tranche2,
                'finance_tranche3' => $finance_tranche3,
                'finance_tranche4' => $finance_tranche4,
                'finance_retention' => $finance_retention,
                'finance_tranche1_date' => $finance_tranche1_date,
                'finance_tranche2_date' => $finance_tranche2_date,
                'finance_tranche3_date' => $finance_tranche3_date,
                'finance_tranche4_date' => $finance_tranche4_date,
                'finance_total' => $finance_total,
                'finance_actuals' => $finance_actuals,
                'finance_variance'=> $finance_variance,
                'finance_burn_rate' => $finance_burn_rate,
                'created_at' => date("Y-m-d h:i:s"),
                'created_by' => $user_name,
                'updated_at' => date("Y-m-d h:i:s"),
                'updated_by' => $user_name,
            ]);
            if($insertData) $success=true;
        }else{
            $finance_id = $finance -> finance_id;

            if( $finance_id != -1 ){ 
                $updateData = DB::table('finance')->where('finance_id',$finance_id)
                    ->update(array(
                        'finance_name' => $raw_data->finance_name,
                        'finance_budget' => $finance_budget,
                        'finance_tranche1' => $finance_tranche1,
                        'finance_tranche2' => $finance_tranche2,
                        'finance_tranche3' => $finance_tranche3,
                        'finance_tranche4' => $finance_tranche4,
                        'finance_retention' => $finance_retention,
                        'finance_tranche1_date' => $finance_tranche1_date,
                        'finance_tranche2_date' => $finance_tranche2_date,
                        'finance_tranche3_date' => $finance_tranche3_date,
                        'finance_tranche4_date' => $finance_tranche4_date,
                        'finance_total' => $finance_total,
                        'finance_actuals' => $finance_actuals,
                        'finance_variance'=> $finance_variance,
                        'finance_burn_rate' => $finance_burn_rate,
                        'updated_at' => date("Y-m-d h:i:s"),
                        'updated_by' => $user_name,
                    ));
                if($updateData) $success=true;
            }
        }

        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }

    public function deleteFinanceTracker(Request $request){
        $ID = $request['delete_id'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $deleteData = DB::table('finance')->where('finance_id',$ID)
            ->update(array("deleted_at"=> date("Y-m-d h:i:s"), "deleted_by" => $user_name));
        if($deleteData) $success=true;
        $data_arr = [
            "success" => $success
        ];
        return response()->json($data_arr, 200);
    }
}
