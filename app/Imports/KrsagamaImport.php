<?php

namespace App\Imports;

use App\Models\Krsagama;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Throwable;

class KrsagamaImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        return new Krsagama([
            'nim'    => $row['nim'],
            'kd_mtk' => $row['kd_mtk'],
            

        ]);

    }

    public function onError(Throwable $error)
    {

    }
}
