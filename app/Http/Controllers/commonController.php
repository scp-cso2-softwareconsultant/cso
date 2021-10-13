<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exports\csoExport;
use App\Exports\exportMult;
use Excel;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class commonController extends Controller
{

    public function getDistinctAssessmentDate(){
        $get_Dates = DB::table("lro_assessment")->selectRaw(DB::raw('Year(assessment_date) as year'))
        ->whereRaw(DB::raw("deleted_at IS NULL"))
        ->orderBy('year','asc')->distinct()->get(['year']);
        $ass_dates = [];
        //Log::info(json_encode($get_Dates));
        if($get_Dates)
            foreach ($get_Dates as $key => $row){
                $ass_dates[$key] = json_decode(json_encode($row));
            }

        //Log::info("GETTING ASSESSMENT DATE");
        //Log::info($get_Dates);
        return $ass_dates;
    }

    public function getDashBoardDistinctFinance(){
        $get_Dates = DB::table("finance AS f")
        ->selectRaw(DB::raw('YEAR(f.updated_at) AS year,MONTHNAME(f.updated_at) AS month, f.finance_name, count(f.finance_id) as count, sum(f2.finance_budget) as TotalBudget, sum(f2.finance_tranche1 + f2.finance_tranche2 + f2.finance_tranche3 + f2.finance_tranche4) AS TotalExpenditure'))
        ->leftJoin("finance AS f2","f2.finance_id","f.finance_id")
        ->whereRaw(DB::raw("f.deleted_at IS NULL AND f.updated_at IS NOT NULL"))
        ->groupBy(DB::raw("f.finance_name"))
        ->get(['year']);
        $ass_dates = [];
        //Log::info(json_encode($get_Dates));
        if($get_Dates)
            foreach ($get_Dates as $key => $row){
                $ass_dates[$key] = json_decode(json_encode($row));
            }
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
        $dataExport = (object)[];

        $data1 = (object)[];
        $data2 = (object)[];
        $sheets = (object)[];
        $sheets_data = (object)[];

        $Exmode = 0;


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
                    $result1 = DB::table("cso_indicator AS ci")
                            ->select(DB::raw("ci.*"))
                            ->where("ci.cso_category","Activity")
                            ->whereNull("ci.deleted_at")
                            ->get();
                            

                    /* 
                        @Senpai
                        select ci.cso_act_no ,i.* from indicator i
                        left join cso_indicator ci on i.cso_indicator_id = ci.cso_indicator_id
                        where
                            ci.cso_category = 'Activity' and
                            ci.deleted_at is null and i.deleted_at is null
                            and ci.cso_act_no is not null 
                    */
                    $result2 = DB::table("indicator AS i")
                                ->select(DB::raw("ci.cso_act_no , i.*"))
                                ->leftJoin("cso_indicator AS ci","ci.cso_indicator_id","i.cso_indicator_id")
                                ->where("ci.cso_category","Activity")
                                ->whereNull("ci.deleted_at")
                                ->whereNull("i.deleted_at")
                                ->whereNotNull("ci.cso_act_no")
                                ->get();

                    $dataExport -> SH_HEADERS = ["Activity","Sub Activity"];
                    $data1 -> title = $dataExport-> SH_HEADERS[0];
                    $data1 -> dataHeaders = ["ACTIVITY NO", "LEAD ORGANIZATION", "DESCRIPTION", "STATUS", "CREATED BY","CREATED AT","UPDATED BY","UPDATED AT"];
                    $data1 -> defaultHeaders = ["cso_act_no","cso_lead_organization","cso_description","cso_status","created_by","created_at","updated_by","updated_at"];
                    $data1 -> data = $result1;
                    $dataExport->SH_DATA[0] = json_decode(json_encode($data1));

                    $data2 -> title = $dataExport-> SH_HEADERS[1];

                    $data2 -> dataHeaders = ["SUB OF","SUB ACTIVITY NO","DESCRIPTION","TYPE","DATA SOURCE","ATTACHED FILE","FREQUENCY","UNIT OF MEASURE","STATUS","REMAKRS","PPR","BASELINE DATE","BASELINE VALUE","TARGET DATE","TARGET VALUE","ACTUAL DATE","CREATED BY","CREATED AT","UPDATED BY","UPDATED AT"];
                    $data2 -> defaultHeaders = ["cso_act_no","indicator_no","indicator","indicator_type","data_source","mov_file","frequency","unit_measure","indicator_status","indicator_remarks","ppr","baseline_date","baseline_value","target_date","target_value","actual_date","created_by","created_at","updated_by","updated_at"];
                    $data2 -> data = $result2;
                    $dataExport->SH_DATA[1] = json_decode(json_encode($data2));

                    $Exmode = 1;
                break;
                case "CSOIndicator-Impact":
                    $result1 = DB::table("cso_indicator AS ci")
                            ->select(DB::raw("ci.*"))
                            ->where("ci.cso_category","Impact")
                            ->whereNull("ci.deleted_at")
                            ->get();

                    $result2 = DB::table("indicator AS i")
                        ->select(DB::raw("ci.cso_act_no , i.*"))
                        ->leftJoin("cso_indicator AS ci","ci.cso_indicator_id","i.cso_indicator_id")
                        ->where("ci.cso_category","Impact")
                        ->whereNull("ci.deleted_at")
                        ->whereNull("i.deleted_at")
                        ->whereNotNull("ci.cso_act_no")
                        ->get();
                    $dataExport -> SH_HEADERS = ["Impact","Sub Impact"];
                    $data1 -> title = $dataExport-> SH_HEADERS[0];
                    $data1 -> dataHeaders = ["IMPACT NO", "DESCRIPTION", "STATUS", "CREATED BY","CREATED AT","UPDATED BY","UPDATED AT"];
                    $data1 -> defaultHeaders = ["cso_act_no","cso_description","cso_status","created_by","created_at","updated_by","updated_at"];
                    $data1 -> data = $result1;
                    $dataExport->SH_DATA[0] = json_decode(json_encode($data1));
                    $data2 -> title = $dataExport-> SH_HEADERS[1];
                    $data2 -> dataHeaders = ["SUB OF","INDICATOR NO","DESCRIPTION","TYPE","DATA SOURCE","ATTACHED FILE","FREQUENCY","UNIT OF MEASURE","STATUS","REMAKRS","PPR","BASELINE DATE","BASELINE VALUE","TARGET DATE","TARGET VALUE","ACTUAL DATE","CREATED BY","CREATED AT","UPDATED BY","UPDATED AT"];
                    $data2 -> defaultHeaders = ["cso_act_no","indicator_no","indicator","indicator_type","data_source","mov_file","frequency","unit_measure","indicator_status","indicator_remarks","ppr","baseline_date","baseline_value","target_date","target_value","actual_date","created_by","created_at","updated_by","updated_at"];
                    $data2 -> data = $result2;
                    $dataExport->SH_DATA[1] = json_decode(json_encode($data2));
                    $Exmode = 1;
                    break;
            case "CSOIndicator-Outcome":
                    $result1 = DB::table("cso_indicator AS ci")
                        ->select(DB::raw("ci.*"))
                        ->where("ci.cso_category","Outcome")
                        ->whereNull("ci.deleted_at")
                        ->get();
                    $result2 = DB::table("indicator AS i")
                        ->select(DB::raw("ci.cso_act_no , i.*"))
                        ->leftJoin("cso_indicator AS ci","ci.cso_indicator_id","i.cso_indicator_id")
                        ->where("ci.cso_category","Outcome")
                        ->whereNull("ci.deleted_at")
                        ->whereNull("i.deleted_at")
                        ->whereNotNull("ci.cso_act_no")
                        ->get();
                    $dataExport -> SH_HEADERS = ["Outcome","Sub Outcome"];
                    $data1 -> title = $dataExport-> SH_HEADERS[0];
                    $data1 -> dataHeaders = ["OUTCOME NO", "DESCRIPTION", "STATUS", "CREATED BY","CREATED AT","UPDATED BY","UPDATED AT"];
                    $data1 -> defaultHeaders = ["cso_act_no","cso_description","cso_status","created_by","created_at","updated_by","updated_at"];
                    $data1 -> data = $result1;
                    $dataExport->SH_DATA[0] = json_decode(json_encode($data1));
                    $data2 -> title = $dataExport-> SH_HEADERS[1];
                    $data2 -> dataHeaders = ["SUB OF","INDICATOR NO","DESCRIPTION","TYPE","DATA SOURCE","ATTACHED FILE","FREQUENCY","UNIT OF MEASURE","STATUS","REMAKRS","PPR","BASELINE DATE","BASELINE VALUE","TARGET DATE","TARGET VALUE","ACTUAL DATE","CREATED BY","CREATED AT","UPDATED BY","UPDATED AT"];
                    $data2 -> defaultHeaders = ["cso_act_no","indicator_no","indicator","indicator_type","data_source","mov_file","frequency","unit_measure","indicator_status","indicator_remarks","ppr","baseline_date","baseline_value","target_date","target_value","actual_date","created_by","created_at","updated_by","updated_at"];
                    $data2 -> data = $result2;
                    $dataExport->SH_DATA[1] = json_decode(json_encode($data2));

                    $Exmode = 1;
                    
                break;
            case "CSOIndicator-Output":
                $dataExport = DB::table("cso_indicator")->select(
                    DB::raw("cso_indicator.cso_act_no"),
                    DB::raw("cso_indicator.cso_description"),
                    DB::raw("cso_indicator.cso_status"),
                    DB::raw("cso_indicator.cso_indicator_mov"),
                    DB::raw("cso_indicator.cso_remarks"),
                )
                ->where("cso_indicator.cso_category", 'Output')
                ->whereNull("deleted_at")
                ->get();
                break;
            case "CSOProfile":
                $dataExport = DB::table("cso_profile")->select(
                    DB::raw("cso_id AS 'CSO_ID'" ),
                    DB::raw("cso_year AS 'CSO_YEAR'" ),
                    DB::raw("cso_sec_registration_no AS 'CSO_SEC_REGISTRATION_NO'" ),
                    DB::raw("cso_registration AS 'CSO_REGISTRATION'" ),
                    DB::raw("cso_description AS 'CSO_DESCRIPTION'" ),
                    DB::raw("cso_core_service AS 'CSO_CORE_SERVICE'" ),
                    DB::raw("cso_thematic_areas AS 'CSO_THEMATIC_AREAS'" ),
                    DB::raw("cso_beneficiaries AS 'CSO_BENEFICIARIES'" ),
                    DB::raw("cso_membership_non_government AS 'CSO_MEMBERSHIP_NON_GOVERNMENT'" ),
                    DB::raw("cso_membership_government AS 'CSO_MEMBERSHIP_GOVERNMENT'" ),
                    DB::raw("cso_current_donors AS 'CSO_CURRENT_DONORS'" ),
                    DB::raw("cso_size_funding_portfolio AS 'CSO_SIZE_FUNDING_PORTFOLIO'" ),
                    DB::raw("cso_number_staff AS 'CSO_NUMBER_STAFF'" ),
                    DB::raw("cso_number_networ_members AS 'CSO_NUMBER_NETWOR_MEMBERS'" ),
                    DB::raw("cso_stakeholders AS 'CSO_STAKEHOLDERS'" ),
                    DB::raw("is_lro AS 'IS_LRO'" ),
                    DB::raw("type_of_support AS 'TYPE_OF_SUPPORT'" ),
                    DB::raw("cso_name AS 'CSO_NAME'" ),
                    DB::raw("cso_type AS 'CSO_TYPE'" ),
                    DB::raw("created_by AS 'CREATED_BY'" ),
                    
                )
                ->whereRaw("deleted_at IS NULL")
                ->get();
                break;
            case "FinanceTracker":
                $dataExport = DB::table("finance")->select(
                    DB::raw("
                                finance_name,
                                finance_budget,
                                finance_tranche1,
                                finance_tranche2,
                                finance_tranche3,
                                finance_tranche4,
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

                    $Exmode = 1;

                    $result = DB::table("lro_assessment AS la")->select(
                        DB::raw("la.lro_assessment_id, cp.cso_name, la.tool_used, la.conducted_by, la.assessment_date, la.final_score, la.mov, la.status, la.created_by, la.created_at,  la.updated_by, la.updated_at ")
                    )
                    ->leftJoin('cso_profile AS cp','cp.cso_profile_id','la.lro_id')
                    ->whereRaw(DB::raw("la.deleted_at IS NULL"))
                    ->whereRaw(DB::raw("cp.deleted_at IS NULL"))->get();


                    /*
                        @SENPAI
                        
                        For Future Dev

                        **& SQL FORM OF THE BELOW QUERY &**
                            select la.lro_assessment_id as Assessment_Record_No, cp.cso_name, ls.sub_domain, ls.rating, ls.file_attachment, ls.remarks, ls.created_at, ls.created_by from lro_assessment_sub ls
                            left join lro_assessment la on ls.lro_assessment_id = la.lro_assessment_id
                            right join cso_profile cp on la.lro_id = cp.cso_profile_id
                            where ls.deleted_at is null AND cp.deleted_at is null
                            AND la.deleted_at is null AND la.lro_assessment_id is not null AND ls.sub_domain is not null
                            group by ls.lro_sub_id
                    */
                    $result2 = DB::table("lro_assessment_sub AS ls")->select(
                        DB::raw("la.lro_assessment_id, cp.cso_name, ls.sub_domain, ls.rating , ls.file_attachment, ls.remarks,ls.created_by,ls.created_at, ls.updated_by, ls.updated_at")
                    )
                    ->leftJoin('lro_assessment AS la','ls.lro_assessment_id','la.lro_assessment_id')
                    ->leftJoin('cso_profile AS cp','cp.cso_profile_id','la.lro_id')
                    ->whereRaw(DB::raw("ls.deleted_at is null AND cp.deleted_at is null AND la.deleted_at is null AND la.lro_assessment_id is not null AND ls.sub_domain is not null"))
                    ->get();

                    $dataExport -> SH_HEADERS = ["LRO ASSESSMENT", "ASSESSMENT SUB"];
                    
                    $data1 -> title = $dataExport-> SH_HEADERS[0];
                    $data2 -> title = $dataExport-> SH_HEADERS[1];

                    $data1 -> dataHeaders = ["ASSESSMENT RECORD NO","NAME OF LRO","TOOL USED","CONDUCTED BY","ASSESSMENT DATE","FINAL SCORE","MOV","STATUS", "CREATED BY", "CREATED AT","UPDATED BY","UPDATED AT" ];
                    $data1 -> defaultHeaders = ["lro_assessment_id", "cso_name", "tool_used", "conducted_by", "assessment_date", "final_score", "mov", "status", "created_by","created_at", "updated_by","updated_at"];

                    $data2 -> dataHeaders = ["ASSESSMENT RECORD NO","CSO NAME","DOMAIN","RATING","FILE ATTACHMENT","REMARKS","CREATED BY","DATE CREATED","UPDATED BY","DATE UPDATED"];
                    $data2 -> defaultHeaders = ["lro_assessment_id","cso_name","sub_domain","rating","file_attachment","remarks", "created_by","created_at", "updated_by","updated_at",];

                    $data1 -> data = $result;
                    $data2 -> data = $result2;
                    
                    $dataExport->SH_DATA[0] = json_decode(json_encode($data1));
                    $dataExport->SH_DATA[1] = json_decode(json_encode($data2));
                    
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


        // EXAMPLe
        //$dataExport2 = json_decode("{\"SH_HEADERS\":[\"SH1\",\"SH2\"],\"SH_DATA\":[{\"title\":\"SH1\",\"dataHeaders\":[\"Name WA\",\"Impression WA\"],\"defaultHeaders\":[\"NameZ\",\"ImpressionZ\"],\"data\":[{\"NameZ\":\"Name1\",\"ImpressionZ\":\"Nice\"},{\"NameZ\":\"Name2\",\"ImpressionZ\":\"Weeb\"}]},{\"title\":\"SH2\",\"defaultHeaders\":[\"NameX\",\"ImpressionX\"],\"dataHeaders\":[\"HELLO WA2\",\"WORLD WA3\"],\"data\":[{\"NameX\":\"Name1\",\"ImpressionX\":\"Nice\"},{\"NameX\":\"Name2\",\"ImpressionX\":\"Weeb\"}]}]}");
        
        if($Exmode == 1)
            return Excel::download((new exportMult($dataExport->SH_HEADERS,$dataExport->SH_DATA)),"JERB.xlsx");
        return Excel::download( (new csoExport)->forTableName($tableName)->forDataExport($dataExport),  $fileName);
    }
}

