<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'checklogin'], function () {
    Route::get("/listcategory", [CategoryController::class, 'index'])->name('category.list');
    Route::post("/ajaxprocess", [CategoryController::class, 'process'])->name('ajax.process');
    Route::get("/getdata", [CategoryController::class, 'getdata'])->name('ajax.getdata');
    Route::get("/delete", [CategoryController::class, 'delete'])->name('ajax.delete');

    Route::get("listrole", [RoleController::class, 'index'])->name('role.list');
    Route::post('/roleprocess', [RoleController::class, 'process'])->name('role.process');
    Route::get('/getrole', [RoleController::class, 'getdata'])->name('role.getdata');
    Route::get('/deleterole', [RoleController::class, 'delete'])->name('role.delete');

    Route::get('/listproduct', [ProductController::class, 'index'])->name('product.list');
    Route::get('/createproduct', [ProductController::class, 'create'])->name('product.create');
    Route::post('/storeproduct', [ProductController::class, 'store'])->name('product.store');
    Route::get('/editproduct/{id}/page/{current}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/updateproduct/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/deleteproduct/{id}/page/{current}', [ProductController::class, 'destroy'])->name('product.delete');
    Route::get('/import', [ProductController::class, 'import'])->name('product.import');
    Route::post('/importprocess', [ProductController::class, 'process'])->name('product.process');
    Route::get('/export', [ProductController::class, 'export'])->name('product.export');

    Route::get('/listuser', [UserController::class, 'index'])->name('user.list');
    Route::get('/createuser', [UserController::class, 'create'])->name('user.create');
    Route::post('/storeuser', [UserController::class, 'store'])->name('user.store');
    Route::get('/edituser/{id}/page/{current}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/updateuser/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/deleteuser/{id}/page/{current}', [UserController::class, 'destroy'])->name('user.delete');
    // Route::get('/login', [UserController::class, 'login'])->name('user.login');
    // Route::post('/loginprocess', [UserController::class, 'loginProcess'])->name('user.login.process');
    // Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
});
    Route::get('/login', [UserController::class, 'login'])->name('user.login');
    Route::post('/loginprocess', [UserController::class, 'loginProcess'])->name('user.login.process');
    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
    Route::get('/forgot', [UserController::class, 'forgot'])->name('forgot');
    Route::post('/forgotprocess', [UserController::class, 'forgotProcess'])->name('forgot.process');
    Route::get('/resetpasword/{token}', [UserController::class, 'resetPasword'])->name('reset.password');
    Route::post('/resetprocess', [UserController::class, 'resetProcess'])->name('reset.process');
    Route::get('/register', [UserController::class, 'register'])->name('user.register');
    Route::post('/registerprocess', [UserController::class, 'registerProcess'])->name('user.register.process');

    Route::get('/home', [HomeController::class, 'home'])->name('home');
    // Route::get('/searchproduct', [HomeController::class, 'search'])->name('search.product');
    Route::get('/showproduct/{id}', [HomeController::class, 'show'])->name('show.product');
    Route::get('/addcart/{id}', [HomeController::class, 'addToCart'])->name('addcart');
    Route::get('/viewcart', [HomeController::class, 'viewCart'])->name('view.cart');
    Route::get('/updatecart', [HomeController::class, 'updateCart'])->name('update.cart');
    Route::get('/deletecart', [HomeController::class, 'deleteCart'])->name('delete.cart');
    Route::get('/searchproduct', [HomeController::class, 'searchProduct'])->name('search.product');
    Route::post('/userlogin', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/userlogout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/userregister', [AuthController::class, 'register'])->name('auth.register');
    Route::get('/insertcart', [HomeController::class, 'insertCard'])->name('insert.card');
    Route::get('/createpdf', [HomeController::class, 'CreatePdf'])->name('checkout');

    Route::post('/loadmore', [HomeController::class, 'loadData'])->name('loadmore.load_data');
