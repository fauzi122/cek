<?php

namespace App\Imports;

use App\Models\Toef_mhs;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class DatamhstoefImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;

    public function  __construct($tes)
    {
        $this->petugas = $tes['petugas'];
    }
    public function model(array $row)
    {

        return new Toef_mhs(
            [

                'nim'       => $row['nim'],
                'nama'      => $row['nama'],
                'kd_lokal'  => $row['kd_lokal'],
                'kd_mtk'    => $row['kd_mtk'],
                'kd_dosen'  => $row['kd_dosen'],
                'petugas'   => $this->petugas,

            ]
        );
    }
    public function onError(Throwable $error)
    {
    }
}
