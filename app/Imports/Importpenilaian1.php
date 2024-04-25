<?php

namespace App\Imports;

use App\Models\baak\Penilaian;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue; //IMPORT SHOUDLQUEUE
use Maatwebsite\Excel\Concerns\WithChunkReading; //IMPORT CHUNK READING

class Importpenilaian implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    public function model(array $row)
    {
        // dd($row[1]);
        return new Penilaian([
    'nim' => $row['nim'],
	'no_krs' => $row['no_krs'],
	'kd_mtk' => $row['kd_mtk'],
	'nilai_uts' => $row['nilai_uts'],
	'nilai_uas' => $row['nilai_uas'],
	'total_nilai' => $row['total_nilai'],
	'nil_absen' => $row['nil_absen'],
	'nil_tgs' => $row['nil_tgs'],
	'grade_akhir' => $row['grade_akhir'],
	'kel_praktek' => $row['kel_praktek'],
	'unggulan' => $row['unggulan'],
	'minat' => $row['minat']
        ]);
    }

	//LIMIT CHUNKSIZE
    public function chunkSize(): int
    {
        return 100000; //ANGKA TERSEBUT PERTANDA JUMLAH BARIS YANG AKAN DIEKSEKUSI
    }

    
}
