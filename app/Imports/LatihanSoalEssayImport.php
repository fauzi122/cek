<?php

namespace App\Imports;

use App\Models\DetailSoalEssay;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class LatihanSoalEssayImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * 
     */

    public function  __construct($tes)
    {
        $this->id_soal = $tes['id_soal'];
        $this->id_user = $tes['id_user'];
        $this->status  = $tes['status'];
    }


    public function model(array $row)
    {

        return new DetailSoalEssay(
            [
                'id_soal' => $this->id_soal,
                'soal'    => $row['soal'],
                'id_user' => $this->id_user,
                'status'  => $this->status,
            ]
        );
    }
    public function onError(Throwable $error)
    {
    }
}
