<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class MahasiswaImport implements ToModel,WithHeadingRow,
SkipsOnError,ShouldQueue,WithChunkReading
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Mahasiswa([
            'nim'       => $row['nim'],
            'nm_mhs'    => $row['nm_mhs'],
            'jns_kel'   => $row['jns_kel'],
            'agm'       => $row['agm'],
            'tgl_lhr'   => $row['tgl_lhr'],
            'tlpn'      => $row['tlpn'],
            'kd_jrs'    => $row['kd_jrs'],
            'kd_lokal'  => $row['kd_lokal']

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