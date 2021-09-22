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
                    'CATEGORY','NO','DESCRIPTION','INDICATOR STATUS','MOV','REMARKS'
                ];
                break;
            case "CSOIndicator-Outcome":
                $header = [
                    'CATEGORY','NO','DESCRIPTION',/*'INTERMEDIATE OUTCOME',*/'INDICATOR STATUS','SUBACTIVITY/INDICATOR NO', 'INDICATOR DESCRIPTION', 'TYPE', 'DATA SOURCE',
                    'FREQUENCY', 'UNIT OF MEASURE','(SUB)INDICATOR STATUS','(SUB)INDICATOR REMARKS','(MOV)MOV FILE', 'PPR', 'BASELINE DATE', 'BASELINE VALUE','TARGET DATE', 'TARGET VALUE', 'ACTUAL DATE'
                ];
                break;
            case "CSOIndicator-Impact":
                $header = [
                            'CATEGORY','NO','DESCRIPTION', 'INDICATOR STATUS', 'SUBACTIVITY/INDICATOR NO', 'INDICATOR DESCRIPTION', 'TYPE', 'DATA SOURCE',
                            'FREQUENCY', 'UNIT OF MEASURE','(SUB)INDICATOR STATUS','(SUB)INDICATOR REMARKS','(MOV)MOV FILE', 'PPR', 'BASELINE DATE', 'BASELINE VALUE',
                            'TARGET DATE', 'TARGET VALUE', 'ACTUAL DATE'
                        ];
                break;
            case "CSOIndicator":
                $header = [
                            'CATEGORY','NO','DESCRIPTION','LEAD ORGANIZATION', 'INDICATOR STATUS', 'SUBACTIVITY/INDICATOR NO', 'INDICATOR DESCRIPTION', 'TYPE', 'DATA SOURCE',
                            'FREQUENCY', 'UNIT OF MEASURE','(SUB)INDICATOR STATUS','(SUB)INDICATOR REMARKS','(MOV)MOV FILE', 'PPR', 'BASELINE DATE', 'BASELINE VALUE',
                            'TARGET DATE', 'TARGET VALUE', 'ACTUAL DATE'
                        ];
                break;
            case "CSOProfile":
                $header = [
                            'IS LRO', 'IS LRO SUPPORTED', 'TYPE OF SUPPORT', 'LONGITUDE', 'LATITUDE',
                            'PROJECT AREA', 'FULL NAME OF THE CSO/CSO NETWORK', 'TYPE OF CSO/CSO NETWORK',
                            'ABBREVIATION', 'ADDRESS', 'TELEPHONE', 'MOBILE NUMBER', 'EMAIL ADDRESS',
                            'WEBSITE/URL', 'FACEBOOK ACCOUNT', 'INSTAGRAM ACCOUNT', 'YOUTUBE ACCOUNT',
                            'OTHER SOCIAL MEDIA ACCOUNT',
                            "NAME OF HEAD OF CSO/CSO NETWORK",
                            "EMAIL ADDRESS OF THE HEAD",
                            "CONTACT NUMBER OF THE HEAD",
                            "YEAR ESTABLISHED",
                            "REGISTRATION WITH/ACCREDITATION",
                            "BRIEF CSO/CSO NETWORK DESCRIPTION (VISION/MISSION)",
                            "BENEFICIARIES",
                            "STAKEHOLDERS",
                            "CAUSE",
                            "MEMBERSHIP LOCAL",
                            "MEMBERSHIP GOVT",
                            "COVID AREAS",
                            "PRE-COVID AREA",
                            "SUPPORT",
                            "RELATIOSHIP SUPPORT TYPE",
                            "RELATIOSHIP SUPPORT LEVEL",
                            "RELATIOSHIP SUPPORT CHANGED",
                            "RELATIOSHIP SUPPORT CHANGED WHY",
                            "PRIVATE SECTOR SUPPORT TYPE",
                            "PRIVATE SECTOR SUPPORT LEVEL",
                            "PRIVATE SECTOR SUPPORT PRIVATE",
                            "PRIVATE SECTOR SUPPORT PRIVATE TYPE",
                            "PRIVATE SECTOR SUPPORT PRIVATE LEVEL",

                        ];
                break;
            case "FinanceTracker":
                $header = [
                            'CODE', 'NAME', 'LOCATION', 'COST CENTER', 'PROJECT CODE', 'SOF', 'DEA', 'PARTNERS NAME',
                            'BUDGET', '1ST TRANCHE', '2ND TRANCHE', '3RD TRANCHE', '4TH TRANCHE', 'RETENTION', 'TOTAL',
                            'ACTUALS', 'VARIANCE', 'BURN RATE (1ST LIQ)', 'BURN RATE (2ND LIQ)', 'BURN RATE (3RD LIQ)',
                            'BURN RATE (4TH LIQ)', 'BURN RATE (TOTAL)'
                        ];
                break;
            case "Assessment":
                $header = [
                    "NAME OF LRO","DOMAIN","TOOL USED","CONDUCTED BY","ASSESSMENT DATE","FINAL SCORE","MOV","STATUS",
                    "CREATED BY","UPDATED AT","UPDATED BY"
                ];  
                break;
            case "ProjectTrackingDocument":
                break;
            case "ParticipantProfile":
                $header = [
                    "PARTICIPANT ID",
                    "PARTICIPANT NAME",
                    "PARTICIPANT LOCATION",
                    "PARTICIPANT ADDRESS",
                    "NAME OF LRO",
                    "PARTICIPANT SKILLS",
                    "PARTICIPANT POSITION",
                    "PARTICIPANT GENDER",
                    "PARTICIPANT AGE",
                    "CREATED AT",
                    "CREATED BY",
                    "UPDATED AT",
                    "UPDATED BY"
                ];
                break;
            case "Courses":
                $header = ["COURSE ID","COURSE NAME","PROJECT AREA","NUMBER OF MODULES","DEVELOPED BY",
                "CREATED AT","CREATED BY","UPDATED AT","UPDATED BY"    
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
        return $this;
    }

}
