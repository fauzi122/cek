<?php

namespace App\Imports;

use App\Models\Detailsoal_ujian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class UjianSoalpgImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;

    private $updatesCount = 0; // Counter untuk pembaruan

    public function  __construct($tes)
    {
        $this->kd_mtk   = $tes['kd_mtk'];
        $this->jenis    = $tes['jenis'];
        $this->score    = $tes['score'];
        $this->id_user  = $tes['id_user'];
        $this->status   = $tes['status'];
        $this->sesi     = $tes['sesi'];
    }

    public function model(array $row)
    {
        $searchAttributes = [
            'kd_mtk' => $this->kd_mtk,
            'jenis'  => $this->jenis,
            'soal'   => $row['soal'],
            'pila'   => $row['pila'],
            'pilb'   => $row['pilb'],
            'pilc'   => $row['pilc'],
            'pild'   => $row['pild'],
            'pile'   => $row['pile'],
            'kunci'  => $row['kunci'],
        ];

        $updateValues = [
            'soal'   => $row['soal'],
            'pila'   => $row['pila'],
            'pilb'   => $row['pilb'],
            'pilc'   => $row['pilc'],
            'pild'   => $row['pild'],
            'pile'   => $row['pile'],
            'kunci'  => $row['kunci'],
            'score'  => $this->score,
            'id_user'=> $this->id_user,
            'status' => $this->status,
            'sesi'   => $this->sesi,
        ];

        $detailSoalUjian = Detailsoal_ujian::updateOrCreate($searchAttributes, $updateValues);

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
