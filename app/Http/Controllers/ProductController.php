<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Requests\ProductRequest;
use File;
use Excel;
use App\Imports\ProductsImport;
use App\Exports\ProductsExport;

class ProductController extends Controller
{

    protected $productRepo;
    protected $cateRepo;

    /**
     * Initialization And Depency Injection.
     *
     * @return $cateRepo, $productRepo
     */

    public function __construct(ProductRepositoryInterface $productRepo, CategoryRepositoryInterface $cateRepo)
    {
        $this->productRepo = $productRepo;
        $this->cateRepo = $cateRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = '';
        if ($request->get('search') != null) {
            $search = $request->get('search');
        }
        $products = $this->productRepo->listProduct($search);
        return view('backend.pages.product.list', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->cateRepo->getAll();
        return view('backend.pages.product.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = array();
        $product['category_id'] = $request->get('category_id');
        $product['product_name'] = $request->get('product_name');
        $image = $request->file('image');
        $arrayImage =  explode( '.', $image->getClientOriginalName());
        $product['image'] = $arrayImage[0].'-'.time().'.'.$arrayImage[1];
        $product['price'] = $request->get('price');
        $product = $this->productRepo->create($product);
        if ($product) {
            $image->move(public_path('uploads'), $product['image']);
            return redirect()->route('product.list')->with('success', 'Add Product successs');
        }else {
            return back()->with('fail', 'Add Product fail');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, $id, $current)
    {
        $categories = $this->cateRepo->getAll();
        $product = $this->productRepo->find($id);
        return view('backend.pages.product.edit', ['categories' => $categories, 'product' => $product, 'currentPage' => $current]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product, $id)
    {
        $currentPage = $request->get('current_page');
        $product = array();
        $product['category_id'] = $request->get('category_id');
        $product['product_name'] = $request->get('product_name');
        $image = $request->file('image');
        $arrayImage =  explode( '.', $image->getClientOriginalName());
        $product['image'] = $arrayImage[0].'-'.time().'.'.$arrayImage[1];
        $product['price'] = $request->get('price');
        $productOld = $this->productRepo->find($id);
        if ($productOld) {
            $imagePath = public_path().'\uploads\\'.$productOld->image;
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            $product = $this->productRepo->update($id,$product);
            if ($product) {
                $image->move(public_path('uploads'), $product['image']);
                return redirect()->route('product.list', ['page' => $currentPage])->with('success', 'Edit Product successs');
            }else {
                return back()->with('fail', 'Edit Product fail');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id, $currentPage)
    {
        $productOld = $this->productRepo->find($id);
        $imageDelete = $productOld->image;
        $product = $this->productRepo->delete($id);
        $imagePath = public_path().'\uploads\\'.$imageDelete;
        if ($product) {
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }
            return redirect()->route('product.list', ['page' => $currentPage])->with('success', 'Delete Product successs');
        }else {
            return back()->with('fail', 'Delete Product fail');
        }
    }

    /**
     * Display view import
     *
     * @param 
     * @return
     */

    public function import()
    {
        return view('backend.pages.product.import');
    }

    /**
     * Store muiltple newly created resource in storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */

    public function process(Request $request)
    {
        $this->validate($request, [
            'excel'  => 'required|mimes:xls,xlsx'
        ]);
        $path = $request->file('excel')->getRealPath(); 
        // $import = new ProductsImport;
        // $import->import($path);
        // dd($import->errors);

        if (Excel::import(new ProductsImport, $path)) {
            return redirect()->route('product.list')->with('success', 'Import Product successs');
        }else {
            return back()->with('Fail', 'Import Product fail');
        }
    }

    /**
     * Export muiltple newly resource in storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */

    public function export()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
