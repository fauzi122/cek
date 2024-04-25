<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImport implements ToModel,WithChunkReading,WithHeadingRow, ShouldQueue
{
    // , ShouldQueue
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'title' => $row['title'],
          
            'description' => $row['description'],
            'price' => $row['price'],
            'stock' => $row['stock']
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
