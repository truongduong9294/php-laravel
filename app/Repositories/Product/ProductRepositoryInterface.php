<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function listProduct($search);

    // public function listlatest();

    // public function listHot();

    // public function listAll();

    public function listFillter($fillter);

    public function getlistProduct();

    public function listSale($search);

    public function listSaleMore($search,$id);
}