<?php

namespace App\Imports;

use App\Models\Mbkm;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class MbkmImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Mbkm([
            'nim'                 => $row['nim'],
            'nm_mhs'              => $row['nm_mhs'],
            'no_krs'              => $row['no_krs'],
            'kd_dosen'            => $row['kd_dosen'],
            'nip'                 => $row['nip'],
            'kd_lokal'            => $row['kd_lokal'],
            'kel_praktek'         => $row['kel_praktek'],
            'kd_mtk'              => $row['kd_mtk'],
            'kd_lokal_mbkm'       => $row['kd_lokal_mbkm'],
            'kd_kampus'           => $row['kd_kampus']

        ]);
    }
    public function onError(Throwable $error)
    {
    }
}
