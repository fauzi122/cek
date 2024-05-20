<?php

namespace App\Imports;

use App\Models\Perakit_soal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class UjianPerakitImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;

    private $updatesCount = 0; // Counter untuk pembaruan

    public function  __construct($tes)
    {
        $this->paket   = $tes['paket'];
        $this->petugas  = $tes['petugas'];
        $this->status   = $tes['status'];
    }

    public function model(array $row)
    {
        $searchAttributes = [
            
            'kd_dosen'  => $row['kd_dosen'],
            'kd_mtk'    => $row['kd_mtk'],
            'paket'     => $this->paket

        ];

        $updateValues = [
            'kd_dosen'  => $row['kd_dosen'],
            'kd_mtk'    => $row['kd_mtk'],
            'paket'     => $this->paket,
            'status' => $this->status,
            'petugas'=> $this->petugas

        ];

        $detailSoalUjian = Perakit_soal::updateOrCreate($searchAttributes, $updateValues);

        // Cek apakah catatan baru dibuat atau diperbarui
        if (!$detailSoalUjian->wasRecentlyCreated && $detailSoalUjian->wasChanged()) {
            $this->updatesCount++; // Tambahkan counter jika diperbarui
        }
    }

    public function onError(Throwable $error)
    {
    }

    // Metode getter untuk counter pembaruan
    public function getUpdatesCount()
    {
        return $this->updatesCount;
    }
}
