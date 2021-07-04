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

    // public function listlatest()
    // {
    //     $listProduct = DB::table('products')
    //                    ->orderBy('id','desc')
    //                    ->limit(6)
    //                    ->get();
    //     return $listProduct;
    // }

    // public function listHot()
    // {
    //     $listProduct = DB::table('products')
    //                    ->inRandomOrder()
    //                    ->orderBy('id','desc')
    //                    ->limit(6)
    //                    ->get();
    //     return $listProduct;
    // }

    // public function listAll()
    // {
    //     $listProduct = DB::table('products')
    //                    ->orderBy('id','desc')
    //                    ->get();
    //     return $listProduct;
    // }

    public function listFillter($fillter, $search = '')
    {
        if ($fillter == 'all' || $fillter == null) {
            $listProduct = DB::table('products')->where('products.product_name', 'like', '%' . $search . '%')->orderBy('id', 'desc')->paginate(4);
        }else {
            $listProduct = DB::table('products')
                            ->join('categories', 'products.category_id', '=' ,'categories.id')
                            ->Where('categories.category_name', '=', $fillter)
                            ->where('products.product_name', 'like', '%' . $search . '%')
                            ->orderBy('products.id', 'desc')
                            ->paginate(4);
        }
        return $listProduct;
    }

    public function getlistProduct()
    {
        $listProduct = DB::table('products')
                    ->orderBy('id', 'desc')
                    ->get();
        return $listProduct;
    }

    public function listSaleMore($search = '', $id)
    {
        $listSale = DB::table('products')
                    ->Where('stock', '!=', 0)
                    ->where('id', '<', $id)
                    ->where('products.product_name', 'like', '%' . $search . '%')
                    ->orderBy('id', 'desc')
                    ->limit(4)
                    ->get();
        return $listSale;
    }

    public function listSale($search = '')
    {
        $listSale = DB::table('products')
                    ->Where('stock', '!=', 0)
                    ->where('products.product_name', 'like', '%' . $search . '%')
                    ->orderBy('id', 'desc')
                    ->limit(4)
                    ->get();
        return $listSale;
    }
}