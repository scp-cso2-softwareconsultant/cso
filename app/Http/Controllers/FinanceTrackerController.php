<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function saveFinanceTracker(Request $request){
        $raw_data = json_decode($request['data']);
        $form_mode = $request['form_mode'];
        $success = false;
        $user = Auth::user();
        $user_name = $user->firstname . ' '. $user->lastname;
        $finance_budget = $raw_data->finance_budget != '' ? $raw_data->finance_budget : 0;
        $finance_tranche1 = $raw_data->finance_tranche1 != '' ? $raw_data->finance_tranche1 : 0;
        $finance_tranche2 = $raw_data->finance_tranche2 != '' ? $raw_data->finance_tranche2 : 0;
        $finance_tranche3 = $raw_data->finance_tranche3 != '' ? $raw_data->finance_tranche3 : 0;
        $finance_tranche4 = $raw_data->finance_tranche4 != '' ? $raw_data->finance_tranche4 : 0;


        $finance_tranche1_date = ( $raw_data->finance_tranche1_date != '') ? date('Y-m-d',strtotime( $raw_data->finance_tranche1_date ) ): '';
        $finance_tranche2_date = ( $raw_data->finance_tranche2_date != '') ? date('Y-m-d',strtotime( $raw_data->finance_tranche2_date ) ): '';
        $finance_tranche3_date = ( $raw_data->finance_tranche3_date != '') ? date('Y-m-d',strtotime( $raw_data->finance_tranche3_date ) ): '';
        $finance_tranche4_date = ( $raw_data->finance_tranche4_date != '') ? date('Y-m-d',strtotime( $raw_data->finance_tranche4_date ) ): '';

        $finance_retention = $raw_data->finance_retention != '' ? $raw_data->finance_retention : 0;
        $finance_total = $finance_tranche1 + $finance_tranche2 + $finance_tranche3 + $finance_tranche4 + $finance_retention;
        $finance_actuals = $raw_data->finance_actuals != '' ? $raw_data->finance_actuals : 0;
        $finance_variance = $finance_total - $finance_actuals;
        $finance_burn1 = $raw_data->finance_burn1 != '' ? $raw_data->finance_burn1 : 0;
        $finance_burn2 = $raw_data->finance_burn2 != '' ? $raw_data->finance_burn2 : 0;
        $finance_burn3 = $raw_data->finance_burn3 != '' ? $raw_data->finance_burn3 : 0;
        $finance_burn4 = $raw_data->finance_burn4 != '' ? $raw_data->finance_burn4 : 0;
        $finance_burn_rate = $finance_burn1 + $finance_burn2 + $finance_burn3 + $finance_burn4;
        if($form_mode < 0) {

            $insertData = DB::table('finance')->insert([
                'finance_name' => $raw_data->finance_name,
                'finance_code' => $raw_data->finance_code,
                'finance_location' => $raw_data->finance_location,
                'finance_cost_center' => $raw_data->finance_cost_center,
                'finance_project_code' => $raw_data->finance_project_code,
                'finance_sof' => $raw_data->finance_sof,
                'finance_dea' => $raw_data->finance_dea,
                'finance_partner' => $raw_data->finance_partner,
                'finance_budget' => $finance_budget,
                'finance_tranche1' => $finance_tranche1,
                'finance_tranche2' => $finance_tranche2,
                'finance_tranche3' => $finance_tranche3,
                'finance_tranche4' => $finance_tranche4,
                'finance_tranche1_date' => $finance_tranche1_date,
                'finance_tranche2_date' => $finance_tranche2_date,
                'finance_tranche3_date' => $finance_tranche3_date,
                'finance_tranche4_date' => $finance_tranche4_date,
                'finance_retention' => $finance_retention,
                'finance_total' => $finance_total,
                'finance_actuals' => $finance_actuals,
                'finance_variance'=> $finance_variance,
                'finance_burn1' => $finance_burn1,
                'finance_burn2' => $finance_burn2,
                'finance_burn3' => $finance_burn3,
                'finance_burn4' => $finance_burn4,
                'finance_burn_rate' => $finance_burn_rate,
                'created_by' => $user_name,
            ]);
            if($insertData) $success=true;
        }else{
            $updateData = DB::table('finance')->where('finance_id',$raw_data->finance_id)
                ->update(array(
                    'finance_name' => $raw_data->finance_name,
                    'finance_code' => $raw_data->finance_code,
                    'finance_location' => $raw_data->finance_location,
                    'finance_cost_center' => $raw_data->finance_cost_center,
                    'finance_project_code' => $raw_data->finance_project_code,
                    'finance_sof' => $raw_data->finance_sof,
                    'finance_dea' => $raw_data->finance_dea,
                    'finance_partner' => $raw_data->finance_partner,
                    'finance_budget' => $finance_budget,
                    'finance_tranche1' => $finance_tranche1,
                    'finance_tranche2' => $finance_tranche2,
                    'finance_tranche3' => $finance_tranche3,
                    'finance_tranche4' => $finance_tranche4,
                    'finance_tranche1_date' => $finance_tranche1_date,
                    'finance_tranche2_date' => $finance_tranche2_date,
                    'finance_tranche3_date' => $finance_tranche3_date,
                    'finance_tranche4_date' => $finance_tranche4_date,
                    'finance_retention' => $finance_retention,
                    'finance_total' => $finance_total,
                    'finance_actuals' => $finance_actuals,
                    'finance_variance'=> $finance_variance,
                    'finance_burn1' => $finance_burn1,
                    'finance_burn2' => $finance_burn2,
                    'finance_burn3' => $finance_burn3,
                    'finance_burn4' => $finance_burn4,
                    'finance_burn_rate' => $finance_burn_rate,
                    'updated_at' => date("Y-m-d h:i:s"),
                    'updated_by' => $user_name,
                ));
            if($updateData) $success=true;
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
