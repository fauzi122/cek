<?php

namespace App\Imports;

use App\Models\Agamakristen;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class AgamaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Agamakristen([
            'no_j_klh' => $row['no_j_klh'],
            'kd_mtk' => $row['kd_mtk'],
            // 'jml_pertemuan' => $row['jml_pertemuan'],
            'kd_dosen' => $row['kd_dosen'],
            'jam_t' => $row['jam_t'],
            'hari_t' => $row['hari_t'],
            'no_ruang' => $row['no_ruang'],
            'kd_lokal' => $row['kd_lokal'],
            'smt_ajar' => $row['smt_ajar'],
            // 'kel_praktek' => $row['kel_praktek'],
            // 'kd_praktek' => $row['kd_praktek'],
            // 'ket' => $row['ket'],
            // 'f' => $row['f'],
            'sksajar' => $row['sksajar'],
            // 'nohari' => $row['nohari'],
            'status_ajar' => $row['status_ajar'],
            'last_update' => $row['last_update'],
            'cek' => $row['cek'],
            // 'konfirmasi' => $row['konfirmasi'],
            // 'calondosen' => $row['calondosen'],
            // 'wawancara' => $row['wawancara'],
            // 'kd_dosen2' => $row['kd_dosen2'],
            // 'nip_aslab' => $row['nip_aslab'],
            // 'nip_aslab2' => $row['nip_aslab2'],
            'kd_gabung' => $row['kd_gabung'],
            // 'u_trans' => $row['u_trans'],

        ]);
    }

    public function onError(Throwable $error)
    {
    }
}
