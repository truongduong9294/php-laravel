<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\OrderDetail\OrderDetailRepositoryInterface;
use Session;
use Illuminate\Support\Facades\Auth;
use PDF;

class HomeController extends Controller
{
    protected $productRepo;
    protected $cateRepo;
    protected $roleRepo;
    protected $orderRepo;
    protected $detailRepo;

    public function __construct(ProductRepositoryInterface $productRepo, CategoryRepositoryInterface $cateRepo, RoleRepositoryInterface $roleRepo, OrderRepositoryInterface $orderRepo, OrderDetailRepositoryInterface $detailRepo)
    {
        $this->productRepo = $productRepo;
        $this->cateRepo = $cateRepo;
        $this->roleRepo = $roleRepo;
        $this->orderRepo = $orderRepo;
        $this->detailRepo = $detailRepo;
    }

    public function home(Request $request)
    {
        $grandTotal = 0;
        $fillter = $request->get('fillter');
        $search  = $request->get('search');
        $products = $this->productRepo->listFillter($fillter, $search);
        $saleProducts = $this->productRepo->listSale($search);
        return view('frontend.pages.home', compact('products', 'fillter', 'search', 'saleProducts'));
    }

    public function show($id)
    {
        if(!isset($request->search)) {
            $search = '';
        }
        $product = $this->productRepo->find($id);
        $products = $this->productRepo->getlistProduct();
        $categories = $this->cateRepo->listCate();
        return view('frontend.pages.show', compact('product', 'products', 'categories'));
    }

    public function addToCart(Request $request, $id)
    {
        $product = $this->productRepo->find($id);
        $cart = Session::get('cart');
        if(!$cart) {
            if ($product->stock != 0) {
                $cart[$product->id] = array(
                    'id'           => $product->id,
                    'product_name' => $product->product_name,
                    'image'        => $product->image,
                    'price'        => $product->price - (($product->stock * $product->price)/100),
                    'quantity'     => 1,
                    'total'        => $product->price - (($product->stock * $product->price)/100)
                );
            }else {
                $cart[$product->id] = array(
                    'id'           => $product->id,
                    'product_name' => $product->product_name,
                    'image'        => $product->image,
                    'price'        => $product->price,
                    'quantity'     => 1,
                    'total'        => $product->price
                );
            }
            session()->put('cart', $cart);
            $count = count($cart);
            return redirect()->route('home')->with( ['count' => $count] );
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            $cart[$id]['total'] = $cart[$id]['quantity'] * $cart[$id]['price'];
            session()->put('cart', $cart);
            return redirect()->route('home');
        }
        if ($product->stock != 0) {
            $cart[$id] = [
                'id'           => $product->id,
                'product_name' => $product->product_name,
                'image'        => $product->image,
                'price'        => $product->price - (($product->stock * $product->price)/100),
                'quantity'     => 1,
                'total'        => $product->price - (($product->stock * $product->price)/100)
            ];
        }else {
            $cart[$id] = [
                'id'           => $product->id,
                'product_name' => $product->product_name,
                'image'        => $product->image,
                'price'        => $product->price,
                'quantity'     => 1,
                'total'        => $product->price
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('home');
    }

    public function viewCart()
    {
        $cart = [];
        $grandTotal = 0;
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            foreach($cart as $item) {
                $grandTotal += $item['total'];
            }
        }
        // $cart['grandTotal'] = $grandTotal;
        $categories = $this->cateRepo->listCate();
        return view('frontend.pages.cart', compact('categories', 'cart', 'grandTotal'));
    }

    public function updateCart(Request $request)
    {
        $cart = Session::get('cart');
        $id = $request->get('id');
        $quantity = $request->get('quantity');
        $grandTotal = 0;
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $quantity;
            $cart[$id]['total'] = $quantity * $cart[$id]['price'];
            foreach($cart as $item) {
                $grandTotal += $item['total'];
            }
            view()->share('grandTotal',$grandTotal);
            session()->put('cart', $cart);
        }
        $output = array(
            'cart'   => $cart,
            'grandTotal'      => $grandTotal,
        );
        echo json_encode($output);
    }

    public function deleteCart(Request $request)
    {
        $grandTotal = 0;
        $cart = Session::get('cart');
        $id = $request->get('id');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        foreach($cart as $item) {
            $grandTotal += $item['total'];
        }
        $output = array(
            'cart'   => $cart,
            'grandTotal'      => $grandTotal,
        );
        echo json_encode($output);
    }

    public function insertCard() {
        $grandTotal = 0;
        $orderDetail = array();
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            foreach($cart as $item) {
                $grandTotal += $item['total'];
            }
            $fieldOrder = [
                'user_id' => Auth::user()->id,
                'total'   => $grandTotal
            ];

            $order = $this->orderRepo->create($fieldOrder);
            if ($order) {
                foreach($cart as $item) {
                    $orderDetail = [
                        'product_id'    => $item['id'],
                        'quantity'      => $item['quantity'],
                        'product_price' => $item['price'],
                        'order_id'      => $order->id,
                        'subtotal'      => $item['price'] * $item['quantity']
                    ];
                    $detailOrder = $this->detailRepo->create($orderDetail);
                }
                if ($detailOrder) {
                    view()->share('grandTotal',$grandTotal);
                    // return view('frontend.pages.checkout', compact('grandTotal')); 
                    $pdf = PDF::loadView('frontend.pages.checkout', ['grandTotal'=>$grandTotal]);
                    $request->session()->forget('cart'); 
                    return $pdf->download('pdf_file.pdf');
                }
            }
        }
    }

    public function loadData(Request $request)
    {
        if($request->ajax()) {
            $search = $request->search;
            if($request->id > 0) {
                $data = $this->productRepo->listSaleMore($search, $request->id);
            }else {
                $data = $this->productRepo->listSale($search, $request->id);
            }
        }
        $output = '';
        $last_id = '';
        if (!$data->isEmpty()) {
            foreach($data as $product) {
                $output .= '
                    <div class="col-lg-3 col-md-6 special-grid">
                        <div class="products-single fix">
                            <div class="box-img-hover">
                                <div class="type-lb">
                                    <p class="sale">- '. $product->stock .''."%".'</p>
                                </div>
                                <img style="witdh: 255px; height: 255px;" src="'.asset("uploads/".$product->image).'" class="img-fluid" alt="Image">
                                <div class="mask-icon">
                                    <ul>
                                        <li><a href="'. route('show.product',$product->id) . '" data-toggle="tooltip" data-placement="right" title="View"><i class="fas fa-eye"></i></a></li>
                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="Compare"><i class="fas fa-sync-alt"></i></a></li>
                                        <li><a href="#" data-toggle="tooltip" data-placement="right" title="Add to Wishlist"><i class="far fa-heart"></i></a></li>
                                    </ul>
                                    <a class="cart add_to_cart" href="' . route('addcart',$product->id). '">Add to Cart</a>
                                </div>
                            </div>
                            <div class="why-text">
                                <h4> ' . $product->product_name .' </h4>
                                <div class="discount">
                                    <h5 class="price_old"> $ '. $product->price . '</h5>
                                    <h5> $ '. ($product->price - (($product->price * $product->stock)/100)) .'</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
                $last_id = $product->id;
            }
            $output .= '
                <div class="load_more">
                    <button class="btn btn-primary" data-id="'.$last_id.'" id="load_more_button">Load More</button>
                </div>
            ';
        }else {
            $output .= '
                <div class="load_more">
                    <button class="btn btn-primary">No Data Found</button>
                </div>
            ';
        }
        echo $output;
    }
}
