<?php

namespace App\Imports;

use App\Models\Penilaian_tem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class PenilaianImport implements ToModel,WithChunkReading,
WithHeadingRow, ShouldQueue, SkipsOnError
//
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Penilaian_tem([
            'nim'           => $row['nim'],
            'no_krs'        => $row['no_krs'],
            'kd_mtk'        => $row['kd_mtk'],
            'nilai_uts'     => $row['nilai_uts'],
            'nilai_uas'     => $row['nilai_uas'],
            'total_nilai'   => $row['total_nilai'],
            'nil_absen'     => $row['nil_absen'],
            'nil_tgs'       => $row['nil_tgs'],
            'grade_akhir'   => $row['grade_akhir'],
            'kel_praktek'   => $row['kel_praktek'],
            'unggulan'      => $row['unggulan'],
            'minat'         => $row['minat']
        ]);
    }

   
    public function chunkSize(): int
    {
        return 3000;
    }
    public function onError(Throwable $error)
    {
        
    }
    
}
