<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;

class TestController
{
    public function oneToOne()
    {
        $data = Customer::with('profile')->orderBy('id', 'desc')->get();
        return response()->json($data);
    }
    public function oneToMany()
    // method 1
    // {
    //     $data = Customer::with('orders.items')->get();
    //     return response()->json($data);
    // }
    // method 2
    // {
    //     $data = Customer::with(['orders.items', 'orders.payments', 'profile'])->get();
    //     return response()->json($data);
    // }

    // method 3
    // {
    //     $data = Customer::with(['orders.items'=> function ($query) {
    //         $query->select('order_id', 'product_id', 'qty', 'unit_price');
    //     }])->get();
    //     return response()->json($data);
    // }

    // method 4
     {
        $data = Customer::select('id', 'name', 'email', 'phone')->with([
            'orders' => function ($query) {
                $query->select('id', 'customer_id', 'order_no', 'status', 'grand_total')->orderBy('id', 'desc');
            },
            'orders.items' => function($query) {
                $query->select('id','order_id','product_id','qty','unit_price')->orderBy('id', 'desc');
            }
        ])->orderBy('id', 'desc')->get();


        return response()->json($data);
    }


    // public function oneToManyRev()
    // {
    //     $data = Order::with('customer')->get();
    //     return response()->json($data);
    // }
}
