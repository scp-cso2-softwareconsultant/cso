<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\Log;

class exportMult implements FromArray, WithMultipleSheets
{
    protected $sheets;
    protected $sheets_data;

    public function __construct(array $sheets, $sheets_data)
    {
        $this->sheets = $sheets;
        $this->sheets_data = $sheets_data;
    }

    public function array(): array
    {
        return $this->sheets;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->sheets_data as $key => $val){ 
            Log::info("PASSING ".json_encode($val));
            $sheets[] = new generateExcelStructure($val);
        }
        return $sheets;
    }
}