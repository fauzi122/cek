<?php

namespace App\Imports;

use App\Models\Userujian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class UserujianImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Userujian([
            'name'          => $row['name'],
            'username'      => $row['username'],
            'kode'          => $row['kode'],
            'email'         => $row['email'],
            // 'password'      => bcrypt('mhs-2023'),
            'password' => bcrypt('mhs-' . date('Y')),
            'utype'         => ('MHS'),
            'kondisi'       => $row['kondisi']

        ]);
    }
    public function onError(Throwable $error)
    {
    }
}
