<?php


namespace App\Exports;

use App\Models\CSO_Indicator;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection; 
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

//LOGING PURPOSE ONLY
use Illuminate\Support\Facades\Log;

class csoExport implements ShouldAutoSize, FromCollection, WithHeadings
{
    use Exportable;
    public $tableName = "";
    public $dataExport = "";
    public function collection()
    {
//        return CSO_Indicator::all();
        return collect($this->dataExport);
    }

    public function headings(): array
    {
        $header = [];
        Log::info($this->tableName);
        switch ($this->tableName){
            case "CSOIndicator-Output":
                $header = [
                    'OUTPUT NO','DESCRIPTION','INDICATOR STATUS','MOV','REMARKS'
                ];
                break;
            // case "CSOIndicator-Outcome":
            //     $header = [
            //         'OUTCOME NO','DESCRIPTION',/*'INTERMEDIATE OUTCOME',*/'INDICATOR STATUS','SUBACTIVITY/INDICATOR NO', 'INDICATOR DESCRIPTION', 'TYPE', 'DATA SOURCE',
            //         'FREQUENCY', 'UNIT OF MEASURE','(SUB)INDICATOR STATUS','(SUB)INDICATOR REMARKS','(MOV)MOV FILE', 'PPR', 'BASELINE DATE', 'BASELINE VALUE','TARGET DATE', 'TARGET VALUE', 'ACTUAL DATE'
            //     ];
            //     break;
            // case "CSOIndicator-Impact":
            //     $header = [
            //                 'IMPACT NO','DESCRIPTION', 'INDICATOR STATUS', 'SUBACTIVITY/INDICATOR NO', 'INDICATOR DESCRIPTION', 'TYPE', 'DATA SOURCE',
            //                 'FREQUENCY', 'UNIT OF MEASURE','(SUB)INDICATOR STATUS','(SUB)INDICATOR REMARKS','(MOV)MOV FILE', 'PPR', 'BASELINE DATE', 'BASELINE VALUE',
            //                 'TARGET DATE', 'TARGET VALUE', 'ACTUAL DATE'
            //             ];
            //     break;
            // case "CSOIndicator":
            //     $header = [
            //                 'ACTIVITY NO','DESCRIPTION','LEAD ORGANIZATION', 'INDICATOR STATUS', 'SUBACTIVITY/INDICATOR NO', 'INDICATOR DESCRIPTION', 'TYPE', 'DATA SOURCE',
            //                 'FREQUENCY', 'UNIT OF MEASURE','(SUB)INDICATOR STATUS','(SUB)INDICATOR REMARKS','(MOV)MOV FILE', 'PPR', 'BASELINE DATE', 'BASELINE VALUE',
            //                 'TARGET DATE', 'TARGET VALUE', 'ACTUAL DATE'
            //             ];
            //     break;
            case "CSOProfile":
                $header = [
                    'CSO_ID', 
                    'CSO_YEAR', 
                    'CSO_SEC_REGISTRATION_NO', 
                    'CSO_REGISTRATION', 
                    'CSO_DESCRIPTION', 
                    'CSO_CORE_SERVICE', 
                    'CSO_THEMATIC_AREAS', 
                    'CSO_BENEFICIARIES', 
                    'CSO_MEMBERSHIP_NON_GOVERNMENT', 
                    'CSO_MEMBERSHIP_GOVERNMENT', 
                    'CSO_CURRENT_DONORS', 
                    'CSO_SIZE_FUNDING_PORTFOLIO', 
                    'CSO_NUMBER_STAFF', 
                    'CSO_NUMBER_NETWOR_MEMBERS', 
                    'CSO_STAKEHOLDERS', 
                    'IS_LRO', 
                    'TYPE_OF_SUPPORT', 
                    'CSO_NAME', 
                    'CSO_TYPE', 
                    'CREATED_BY',

                    ];
                break;
            case "FinanceTracker":
                $header = [
                    'finance_name',
                    'finance_budget',
                    'finance_tranche1',
                    'finance_tranche2',
                    'finance_tranche3',
                    'finance_tranche4',
                    'finance_total',
                    'finance_actuals',
                    'finance_variance',
                    'finance_burn_rate', 
                        ];
                break;
            case "ProjectTrackingDocument":
                break;
            case "Participants Profile":
                $header = [
                    "PARTICIPANT ID",
                    "PARTICIPANT NAME",
                    "PARTICIPANT LOCATION",
                    "PARTICIPANT ADDRESS",
                    "NAME OF LRO",
                    "POSITION IN ORGANIZATION",
                    // "PARTICIPANT SKILLS",
                    "PARTICIPANT POSITION",
                    "PARTICIPANT GENDER",
                    "PARTICIPANT AGE",
                    "CSO AFFILIATION",
                    "DATE OF TRAINING",
                    "CREATED AT",
                    "CREATED BY",
                    "UPDATED AT",
                    "UPDATED BY"
                ];
                break;
            case "Courses":
                $header = [
                    "COURSE ID",
                    "TRAINING COURSE",
                    "DATE OF TRAINING",
                    "CONDUCTED BY",
                    "NUMBER OF PARTICIPANTS",
                    "PROJECT AREA",
                    "DEVELOPED BY",
                    "CREATED AT",
                    "CREATED BY",
                    "UPDATED AT",
                    "UPDATED BY"    
            ];
                break;
                case "TrainingAttendees":
                    $header = [
                        "TRAINING ID","PARTICIPANT ID","PARTICIPANT NAME","COURSE NAME",
                        "PROJECT AREA","DATE STARTED","DATE COMPLETED","MODE OF TRAINING","NO HOURS","CONDUCTED BY","VENUE",
                        "CREATED AT","CREATED BY","UPDATED AT","UPDATED BY"
                    ];
                break;
        }
        Log::info($this->tableName);
        return $header;
    }

    public function forTableName(string $tableName){
        $this->tableName = $tableName;
        return $this;
    }

    public function forDataExport(string $dataExport){
        $this->dataExport = json_decode($dataExport,true);
        Log::info("EXPORTING: ".json_encode($dataExport, true));
        return $this;
    }

}
