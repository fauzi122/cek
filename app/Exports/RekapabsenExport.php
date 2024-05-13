<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapabsenExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'NIM', 'Nama Mahasiswa', 'Status', 'Paket Absen', 'Kode Dosen Absen', 'Kode Lokal',
            'Kode Jurusan', 'Kode Cabang', 'No Kelompok Ujian', 'Hari', 'No Ruang', 'Nama Matakuliah',
            'Kode Matakuliah', 'Jam Tertulis', 'Nama Kampus', 'Paket', 'Tanggal Ujian', 'Kode Matakuliah Absen', 'Keterangan'
        ];
    }
    
}
