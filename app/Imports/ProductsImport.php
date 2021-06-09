<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;

class ProductsImport implements ToModel, WithHeadingRow, SkipsOnError, WithValidation
{
    use Importable, SkipsErrors;

    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Product([
            'category_id'    => $row['category_id'],
            'product_name'   => $row['product_name'],
            'image'          => $row['image'],
            'price'          => $row['price'],
        ]);

        // $data = [];
        // foreach($rows->toArray() as $row){
        //     if(is_null($row[0])){
        //         return;
        //     }
        //     $data[] = array(
        //             'category_id'    => $row[0],
        //             'product_name'   => $row[1],
        //             'image'          => $row[2],
        //             'price'          => $row[3],
        //     );
        // }
        // DB::beginTransaction();
        // try {
        //     DB::table('products')->insert($data);
        //     DB::commit();
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     throw new Exception($e->getMessage());
        // }
    }

    public function rules(): array
    {
        return [
            '*.category_id'  => ['required', 'integer'],
            '*.product_name' => ['required' , 'min:4', 'max:20'],
            '*.product_name' => ['required' , 'min:4', 'max:20'],
            '*.product_name' => ['required' , 'min:4', 'max:20'],
            '*.price'        => ['required', 'max:8'],
        ];
    }
}
