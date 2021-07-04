<?php
namespace App\Repositories\OrderDetail;

use App\Repositories\BaseRepository;
use DB;

class OrderDetailRepository extends BaseRepository implements OrderDetailRepositoryInterface
{

    public function getModel()
    {
        return \App\Models\OrderDetail::class;
    }

}