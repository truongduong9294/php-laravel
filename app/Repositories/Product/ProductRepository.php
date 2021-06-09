<?php
namespace App\Repositories\Product;

use App\Repositories\BaseRepository;
use DB;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    public function getModel()
    {
        return \App\Models\Product::class;
    }

    public function listProduct($search)
    {
        $listProduct = DB::table('products')
                       ->join('categories','products.category_id', '=' ,'categories.id')
                       ->where('products.product_name', 'like', '%' . $search . '%')
                       ->select('products.*','categories.category_name')
                       ->orderBy('id', 'desc')
                       ->paginate(3);
        return $listProduct;
    }
}