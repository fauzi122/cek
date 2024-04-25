<?php

namespace App\Imports;

use App\Models\Detailsoal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class LatihanSoalpgImport implements ToModel, WithHeadingRow, SkipsOnError
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
        $this->jenis = $tes['jenis'];
        $this->id_user = $tes['id_user'];
        $this->status = $tes['status'];
        $this->sesi = $tes['sesi'];
    }
    public function model(array $row)
    {

        return new Detailsoal(
            [
                'id_soal' => $this->id_soal,
                'jenis' => $this->jenis,
                'soal'      => $row['soal'],
                'pila'      => $row['pila'],
                'pilb'      => $row['pilb'],
                'pilc'      => $row['pilc'],
                'pild'      => $row['pild'],
                'pile'      => $row['pile'],
                'kunci'     => $row['kunci'],
                'score'     => $row['score'],
                'id_user' => $this->id_user,
                'status' => $this->status,
                'sesi' => $this->sesi,
            ]
        );
    }
    public function onError(Throwable $error)
    {
    }
}
