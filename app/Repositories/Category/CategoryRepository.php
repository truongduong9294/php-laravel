<?php
namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use DB;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    public function getModel()
    {
        return \App\Models\Category::class;
    }

    public function getList()
    {
        return DB::table('categories')->orderBy('id', 'desc')->paginate(2);
    }

    public function checkProduct()
    {        
        return DB::table('categories')
               ->join('products','categories.id', '=' ,'products.category_id')
               ->pluck('categories.id');
    }
}