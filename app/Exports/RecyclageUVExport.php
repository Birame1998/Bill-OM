<?php

namespace App\Exports;

use App\Models\Facturation\RecyclageUV;
use Maatwebsite\Excel\Concerns\FromCollection;

class RecyclageUVExport implements FromCollection
{
    public function __construct($c2c_ow)
    {
        $this->c2c_ow = $c2c_ow;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return RecyclageUV::where('c2c',$this->c2c_ow)->orWhere('ow',$this->c2c_ow)->get();
    }
    public function headings(): array
    {
        return [
          '#',
          'c2c',
          'ow'
        ];
    }
}
