<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithMapping;

use Illuminate\Support\Facades\Log;

/*, WithColumnFormatting*/
class generateExcelStructure implements FromArray, WithHeadings, WithTitle, ShouldAutoSize , WithMapping
{
    protected $rows;
    protected $title;
    protected $headers;
    protected $defaultHeaders;

    public function __construct($data)
    {
        Log::info("RECIEVED ".json_encode($data));
        $this->rows = $data->data;
        $this->headers = $data->dataHeaders;
        $this->title = $data->title;
        $this->defaultHeaders = $data->defaultHeaders;
    }

    public function map($row): array
    {   
        $map_res = [];
        foreach($this->defaultHeaders as $key => $val){
           $map_res[] = $row->$val;
        }
        return $map_res;
    }

    public function headings(): array
    {
        return $this->headers;
    }

    public function array(): array
    {   
        Log::info("RETURNING FAULT ".json_encode($this->rows));
        return $this->rows;
    }

    public function title(): string
    {
        return $this->title;
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'B' => '#,##0',
    //         'C' => '#,##0',
    //         'D' => NumberFormat::FORMAT_PERCENTAGE_00
    //     ];
    // }
}
