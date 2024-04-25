<?php

namespace App\Imports;

use App\Models\Userstaff;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class StaffImport implements ToModel,WithHeadingRow,SkipsOnError
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Userstaff([
            'name'          => $row['name'],
            'username'      => $row['username'],
            'kode'          => $row['kode'],
            'email'         => $row['email'], 
            // 'password'      => bcrypt('dosen-2021'),
            'password' => bcrypt('dosen-' . date('Y')),
            'utype'         =>('ADM'), 
            'kondisi'       => $row['kondisi']
           
        ]);
    }
    public function onError(Throwable $error)
    {
        
    }
}
