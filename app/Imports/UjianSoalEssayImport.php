<?php

namespace App\Imports;

use App\Models\DetailSoalEssay_ujian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class UjianSoalEssayImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;

    private $updatesCount = 0; // Counter untuk pembaruan

    public function  __construct($tes)
    {
        $this->kd_mtk  = $tes['kd_mtk'];
        $this->jenis   = $tes['jenis'];
        $this->id_user = $tes['id_user'];
        $this->status  = $tes['status'];
    }

    public function model(array $row)
    {
        $searchAttributes = [
            'kd_mtk' => $this->kd_mtk,
            'jenis'  => $this->jenis,
            'soal'   => $row['soal'],
        ];

        $updateValues = [
            'id_user' => $this->id_user,
            'status'  => $this->status,
        ];

        $detailSoalEssayUjian = DetailSoalEssay_ujian::updateOrCreate($searchAttributes, $updateValues);

        // Cek apakah catatan baru dibuat atau diperbarui
        if (!$detailSoalEssayUjian->wasRecentlyCreated && $detailSoalEssayUjian->wasChanged()) {
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
