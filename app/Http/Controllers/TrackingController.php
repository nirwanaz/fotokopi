<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions as Tr;

class TrackingController extends Controller
{
    //
    public function get($id) {
        $tracking = Tr::select( 'tracking.id as trackid',
                                'customers.name as custname',
                                'customers.address as custaddress',
                                'categories.name as catgname',
                                'statuses.name as statsname',
                                'order_details.total as odtotal' )
                        ->leftjoin('orders', 'orders_id', '=', 'orders.id')
                        ->leftjoin('customers', 'orders.customers_id', '=', 'customers.id')
                        ->leftjoin('categories', 'orders.categories_id', '=', 'categories.id')
                        ->leftjoin('order_details', 'orders.id', '=', 'order_details.orders_id')
                        ->leftjoin('statuses', 'orders.statuses_id', '=', 'statuses.id')
                        ->where('tracking.id', '=', $id)
                        ->get();

        return $tracking->toJson();
    }
}
