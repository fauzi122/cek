<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DetailsoalExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            
            'kd_mtk',
            'jenis',
            'soal',
            'file',
            'pila',
            'pilb',
            'pilc',
            'pild',
            'pile',
            'kunci',

        ];
    }
    
}
