<?php


namespace App\Exports;

use App\Models\CSO_Indicator;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class csoExport implements FromCollection, WithHeadings
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
        switch ($this->tableName){
            case "CSO2 Indicator":
                $header = [
                            'CATEGORY','ACTIVITY NO','DESCRIPTION', 'STATUS', 'INDICATOR NO', 'INDICATOR', 'TYPE', 'DATA SOURCE',
                            'FREQUENCY', 'UNIT OF MEASURE', 'PPR', 'BASELINE DATE', 'BASELINE VALUE',
                            'TARGET DATE', 'TARGET VALUE', 'ACTUAL DATE', 'MOV'
                        ];
                break;
            case "CSO Profile":
                $header = [
                            'IS LRO', 'PROJECT AREA', 'FULL NAME OF THE CSO/CSO NETWORK', 'TYPE OF CSO/CSO NETWORK',
                            'ABBREVIATION', 'ADDRESS', 'TELEPHONE', 'MOBILE NUMBER', 'EMAIL ADDRESS',
                            'WEBSITE/URL', 'FACEBOOK ACCOUNT', 'INSTAGRAM ACCOUNT', 'YOUTUBE ACCOUNT',
                            'OTHER SOCIAL MEDIA ACCOUNT'
                        ];
                break;
            case "Finance Tracker":
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
            case "Project Tracking Document":
                break;
            case "Participant Profile":
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
                case "Training Attendees":
                    $header = [
                        "TRAINING ID","PARTICIPANT ID","PARTICIPANT NAME","COURSE NAME",
                        "PROJECT AREA","DATE STARTED","DATE COMPLETED","MODE OF TRAINING","NO HOURS","CONDUCTED BY","VENUE",
                        "CREATED AT","CREATED BY","UPDATED AT","UPDATED BY"
                    ];
                break;
        }

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
