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
                            'Category', 'Description', 'Status', 'Indicator No', 'Indicator', 'Type', 'Data Source',
                            'Frequency', 'Unit of Measure', 'PPR', 'Baseline Date', 'Baseline Value',
                            'Target Date', 'Target Value', 'Actual Date', 'MOV'
                        ];
                break;
            case "CSO Profile":
                $header = [
                            'Is LRO', 'Project Area', 'Full name of the CSO/CSO Network', 'Type of CSO/CSO Network',
                            'Abbreviation', 'Address', 'Telephone', 'Mobile Number', 'Email Address',
                            'Website/Url', 'Facebook Account', 'Instagram Account', 'Youtube Account',
                            'Other Social Media Account'
                        ];
                break;
            case "Finance Tracker":
                $header = [
                            'Code', 'Name', 'Location', 'Cost Center', 'Project Code', 'SOF', 'DEA', 'Partners Name',
                            'Budget', '1st Tranche', '2nd Tranche', '3rd Tranche', '4th Tranche', 'Retention', 'Total',
                            'Actuals', 'Variance', 'Burn Rate (1st Liq)', 'Burn Rate (2nd Liq)', 'Burn Rate (3rd Liq)',
                            'Burn Rate (4th Liq)', 'Burn Rate (Total)'
                        ];
                break;
            case "Assessment":
                $header = [
                    "lro id","domain","final score","assessment date","conducted by","tool used","mov",
                    "status","created at","created by","updated at","updated by","deleted at","deleted by"
                ];  
                break;
            case "Project Tracking Document":
                break;
            case "Participant Profile":
                $header = [
                    "participant id","participant name","participant location","participant address","participant position","lro id","participan gender","participant age","participant skills",
                    "created at","created by","updated at","updated by","deleted at","deleted_by"
                ];
                break;
            case "Courses":
                $header = ["course id","course name","project area","number of modules","developed by",
                "created at","created by","updated at","updated by","deleted at","deleted by"    
            ];
                break;
                case "Training Attendees":
                    $header = [
                        "Training Id","Participant Id","Participant Name","Course Name",
                        "Project Area","Date Started","Date Completed","Mode Of Training","No Hours","Conducted By","Venue",
                        "created at","created by","updated at","updated by","deleted at","deleted by"
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
