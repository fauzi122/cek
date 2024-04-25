<?php

namespace App\Imports;

use App\Models\Distribusisoal_ujian_tmp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class PesertaujianImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Distribusisoal_ujian_tmp([

            'kd_mtk'           => $row['kd_mtk'],
            'id_kelas'         => $row['id_kelas'],
            'nim'              => $row['nim'],
            'kondisi'          => $row['kondisi'],
            'nm_mhs'           => $row['nm_mhs'],
            'no_kel_ujn'       => $row['no_kel_ujn'],
            'paket'            => $row['paket'],


        ]);
    }
    public function onError(Throwable $error)
    {
    }
}
