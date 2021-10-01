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

    public function getDistinctAssessmentDate(){
        $get_Dates = DB::table("lro_assessment")->selectRaw(DB::raw('Year(assessment_date) as year'))->whereRaw(DB::raw("deleted_at IS NULL"))->orderBy('year','asc')->distinct()->get(['year']);
        $ass_dates = [];
        Log::info(json_encode($get_Dates));
        if($get_Dates)
            foreach ($get_Dates as $key => $row){
                $ass_dates[$key] = json_decode(json_encode($row));
            }

        Log::info("GETTING ASSESSMENT DATE");
        Log::info($get_Dates);
        return $ass_dates;
    }
/*
        select Year(la.assessment_date) as year, las.sub_domain, las.rating from lro_assessment la
        join lro_assessment_sub las on la.lro_assessment_id = las.lro_assessment_id
        right join lro_assessment_sub l on las.lro_assessment_id = l.lro_assessment_id
        where la.deleted_at is null and las.deleted_at is null
        order by year asc, las.sub_domain asc
*/
    public function getDistinctSubDomain(){
        $get_result = DB::table("lro_assessment as la")
        ->join("lro_assessment_sub as las","la.lro_assessment_id","=","las.lro_assessment_id")
        ->select(DB::raw('Year(la.assessment_date) as year, las.sub_domain, las.rating'))
        ->whereRaw(DB::raw("la.deleted_at IS NULL"))
        ->whereRaw(DB::raw("las.deleted_at IS NULL"))
        ->orderBy('year','asc')
        ->orderBy('las.sub_domain','asc')
        ->get();
        return $get_result;
    }

    public function getLROStatus(){
        $get_status = DB::table("lro_status")->select(DB::raw("status_name as text, status_name as value"))->get();
        $status_list = [];
        if($get_status)
            foreach ($get_status as $key => $row)
                $status_list[$key] = json_decode(json_encode($row), true);
        return $status_list;
    }

    public function getDocumentType(){
        $get_type = DB::table("document_type")->select(DB::raw("document_type as text, document_type as value"))->get();
        $type_list = [];
        if($get_type)
            foreach ($get_type as $key => $row)
                $type_list[$key] = json_decode(json_encode($row), true);
        return $type_list;
    }

    public function getDocumentOwner(){
        $get_owner = DB::table("document_owner")->select(DB::raw("document_owner as text, document_owner as value"))->get();
        $owner_list = [];
        if($get_owner)
            foreach ($get_owner as $key => $row)
                $owner_list[$key] = json_decode(json_encode($row), true);
        return $owner_list;
    }

    public function getCategories(){
        $get_categories = DB::table("categories")->select(DB::raw("category as text, category as value"))->orderBy("seq")->get();
        $category_list = [];
        if($get_categories)
            foreach ($get_categories as $key => $row)
                $category_list[$key] = json_decode(json_encode($row), true);
        return $category_list;
    }

    public function getIndicatorStatus(){
        $get_status = DB::table("indicator_status")->select(DB::raw("indicator_status as text, indicator_status as value"))->get();
        $status_list = [];
        if($get_status)
            foreach ($get_status as $key => $row)
                $status_list[$key] = json_decode(json_encode($row), true);
        return $status_list;
    }

    public function getLeadOrgs(){
        $leadOrgs = DB::table("lead_organization")->select(DB::raw("organization_name as text, organization_name as value"))->get();
        $leadOrgs_list = [];
        if($leadOrgs)
            foreach ($leadOrgs as $key => $row)
                $leadOrgs_list[$key] = json_decode(json_encode($row), true);
        return $leadOrgs_list;
    }

    public function getFrequencies(){
        $get_frequencies = DB::table("frequencies")->select(DB::raw("frequency as text, frequency as value"))->get();
        $frequency_list = [];
        if($get_frequencies)
            foreach ($get_frequencies as $key => $row)
                $frequency_list[$key] = json_decode(json_encode($row), true);
        return $frequency_list;
    }

    public function getIndicatorType(){
        $get_type = DB::table("indicator_type")->select(DB::raw("indicator_type as text, indicator_type as value"))->get();
        $type_list = [];
        if($get_type)
            foreach ($get_type as $key => $row)
                $type_list[$key] = json_decode(json_encode($row), true);
        return $type_list;
    }

    public function getAccreditations(){
        $get_type = DB::table("accreditation")->select(DB::raw("accreditation_name as text, accreditation_name as value"))->get();
        $type_list = [];
        if($get_type)
            foreach ($get_type as $key => $row)
                $type_list[$key] = json_decode(json_encode($row), true);
        return $type_list;
    }

    public function getStakeHolders(){
        $get_type = DB::table("stakeholders")->select(DB::raw("stakeholder_name as text, stakeholder_name as value"))->get();
        $type_list = [];
        if($get_type)
            foreach ($get_type as $key => $row)
                $type_list[$key] = json_decode(json_encode($row), true);
        return $type_list;
    }

    public function getParticipants(){
        $get_participant = DB::table("participant_profile")->select(DB::raw("participant_name as text, participant_id as value"))->get();
        $participant_list = [];
        if($get_participant)
            foreach ($get_participant as $key => $row)
                $participant_list[$key] = json_decode(json_encode($row), true);

        return $participant_list;
    }

    public function getCourses(){
        $get_course = DB::table("courses")->select(DB::raw("course_name as text, course_id as value"))->get();
        $course_list = [];
        if($get_course)
            foreach ($get_course as $key => $row)
                $course_list[$key] = json_decode(json_encode($row), true);
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
                        DB::raw("cso_indicator.cso_category"),
                        DB::raw("cso_indicator.cso_act_no"),
                        DB::raw("cso_indicator.cso_description"),
                        DB::raw("cso_indicator.cso_lead_organization"),
                        DB::raw("cso_indicator.cso_status"),
                        DB::raw("indicator.indicator_no"),
                        DB::raw("indicator.indicator"),
                        DB::raw("indicator.indicator_type"),
                        DB::raw("indicator.data_source"),
                        DB::raw("indicator.frequency"),
                        DB::raw("indicator.unit_measure"),
                        DB::raw("indicator.indicator_status"),
                        DB::raw("indicator.indicator_remarks"),
                        DB::raw("indicator.mov_file"),
                        DB::raw("indicator.ppr AS PPR"),
                        DB::raw("indicator.baseline_date"),
                        DB::raw("indicator.baseline_value"),
                        DB::raw("indicator.target_date"),
                        DB::raw("indicator.target_value"),
                        DB::raw("indicator.actual_date"),
                    )
                    ->leftJoin("indicator","cso_indicator.cso_indicator_id", "indicator.cso_indicator_id")
                    ->whereRaw("cso_indicator.deleted_at IS NULL")
                    ->whereRaw("indicator.deleted_at IS NULL")
                    ->where("cso_indicator.cso_category", $request['category'])
                    ->get();
                break;
                case "CSOIndicator-Impact":
                    $dataExport = DB::table("cso_indicator")->select(
                            DB::raw("cso_indicator.cso_category"),
                            DB::raw("cso_indicator.cso_act_no"),
                            DB::raw("cso_indicator.cso_description"),
                            DB::raw("cso_indicator.cso_status"),
                            DB::raw("indicator.indicator_no"),
                            DB::raw("indicator.indicator"),
                            DB::raw("indicator.indicator_type"),
                            DB::raw("indicator.data_source"),
                            DB::raw("indicator.frequency"),
                            DB::raw("indicator.unit_measure"),
                            DB::raw("indicator.indicator_status"),
                            DB::raw("indicator.indicator_remarks"),
                            DB::raw("indicator.mov_file"),
                            DB::raw("indicator.ppr AS PPR"),
                            DB::raw("indicator.baseline_date"),
                            DB::raw("indicator.baseline_value"),
                            DB::raw("indicator.target_date"),
                            DB::raw("indicator.target_value"),
                            DB::raw("indicator.actual_date"),
                        )
                        ->leftJoin("indicator","cso_indicator.cso_indicator_id", "indicator.cso_indicator_id")
                        ->whereRaw("cso_indicator.deleted_at IS NULL")
                        ->whereRaw("indicator.deleted_at IS NULL")
                        ->where("cso_indicator.cso_category", $request['category'])
                        ->get();
                    break;
            case "CSOIndicator-Outcome":
                $dataExport = DB::table("cso_indicator")->select(
                        DB::raw("cso_indicator.cso_category"),
                        DB::raw("cso_indicator.cso_act_no"),
                        DB::raw("cso_indicator.cso_description"),
                        //DB::raw("cso_indicator.cso_intermediate_outcome"),
                        DB::raw("cso_indicator.cso_status"),
                        DB::raw("indicator.indicator_no"),
                        DB::raw("indicator.indicator"),
                        DB::raw("indicator.indicator_type"),
                        DB::raw("indicator.data_source"),
                        DB::raw("indicator.frequency"),
                        DB::raw("indicator.unit_measure"),
                        DB::raw("indicator.indicator_status"),
                        DB::raw("indicator.indicator_remarks"),
                        DB::raw("indicator.mov_file"),
                        DB::raw("indicator.ppr AS PPR"),
                        DB::raw("indicator.baseline_date"),
                        DB::raw("indicator.baseline_value"),
                        DB::raw("indicator.target_date"),
                        DB::raw("indicator.target_value"),
                        DB::raw("indicator.actual_date"),
                    )
                    ->leftJoin("indicator","cso_indicator.cso_indicator_id", "indicator.cso_indicator_id")
                    ->whereRaw("cso_indicator.deleted_at IS NULL")
                    ->whereRaw("indicator.deleted_at IS NULL")
                    ->where("cso_indicator.cso_category", $request['category'])
                    ->get();
                break;
            case "CSOIndicator-Output":
                $dataExport = DB::table("cso_indicator")->select(
                    DB::raw("cso_indicator.cso_category"),
                    DB::raw("cso_indicator.cso_act_no"),
                    DB::raw("cso_indicator.cso_description"),
                    DB::raw("cso_indicator.cso_status"),
                    DB::raw("cso_indicator.cso_indicator_mov"),
                    DB::raw("cso_indicator.cso_remarks"),
                )
                ->where("cso_indicator.cso_category", 'Output')
                ->get();
                break;
            case "CSOProfile":
                $dataExport = DB::table("cso_profile")->select(
                    
                    DB::raw("is_lro AS 'Is LRO'"),
                    DB::raw("is_lro_supported AS 'Is LRO Supported'"),
                    DB::raw("type_of_support AS 'Type Of Suppport'"),
                    DB::raw("longitude AS 'Longitude'"),
                    DB::raw("latitude AS 'Latitude'"),
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
                    DB::raw("cso_socmed AS 'Other Social Media Account'"),
                    DB::raw("cso_head_name AS 'Name of Head of CSO/CSO Network' "),
                    DB::raw("cso_head_email AS 'Email Address of the head' "),
                    DB::raw("cso_head_number AS 'Contact Number of the head' "),
                    DB::raw("cso_year AS 'Year Established' "),
                    DB::raw("cso_registration AS 'Registration with/Accreditation' "),
                    DB::raw("cso_description AS 'Brief CSO/CSO Network description (Vision/Mission)' "),
                    DB::raw("cso_beneficiaries AS 'Beneficiaries' "),
                    DB::raw("cso_stakeholders AS 'Stakeholders' "),
                    DB::raw("cso_cause AS 'Cause' "),
                    DB::raw("cso_membership_local AS 'Membership Local' "),
                    DB::raw("cso_membership_govt AS 'Membership Govt' "),
                    DB::raw("cso_areas_covid AS 'Covid Areas' "),
                    DB::raw("cso_areas_precovid AS 'Pre-covid Areas' "),
                    DB::raw("cso_support AS 'Support' "),
                    DB::raw("cso_rsupport_type AS 'Relatioship support type' "),
                    DB::raw("cso_rsupport_level AS 'Relatioship support level' "),
                    DB::raw("cso_rsupport_changed AS 'Relatioship support changed' "),
                    DB::raw("cso_rsupport_changed_why AS 'Relatioship support changed Why' "),
                    DB::raw("cso_psupport AS 'Private Sector Support' "),
                    DB::raw("cso_psupport_type AS 'Private Sector Support type' "),
                    DB::raw("cso_psupport_level AS 'Private Sector Support Level' "),
                    DB::raw("cso_psupport_private AS 'Private Sector Support Private' "),
                    DB::raw("cso_psupport_private_type AS 'Private Sector Support Private Type' "),
                    DB::raw("cso_psupport_private_level AS 'Private Sector Support Private Level' ")
                    
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
                    DB::raw(
                    "course_id,
                    course_name,
                    training_date,
                    conducted_by, 
                    number_of_participants,
                    project_area,
                    developed_by,
                    created_at,
                    created_by,
                    updated_at,
                    updated_by")
                )->whereRaw("deleted_at IS NULL")->get();
            break; 
            case "TrainingAttendees":
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
