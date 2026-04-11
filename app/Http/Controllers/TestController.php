<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;

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
    //  {
    //     $data = Customer::select('id', 'name', 'email', 'phone')->with([
    //         'orders' => function ($query) {
    //             $query->select('id', 'customer_id', 'order_no', 'status', 'grand_total')->orderBy('id', 'desc');
    //         },
    //         'orders.items' => function($query) {
    //             $query->select('id','order_id','product_id','qty','unit_price')->orderBy('id', 'desc');
    //         }
    //     ])->orderBy('id', 'desc')->get();


    //     return response()->json($data);
    // }
    // method 4 with whereHas
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


    public function manyToMany()
    {
        $products = Product::whereHas('categories', function ($query) {
            $query->where('name', 'Phones');
        })->with('categories')->get();
        return response()->json($products);
    }

    public function productWithCat ()
    {
        $products = Category::with('products')->get();
        return response()->json($products);
    }

    public function selfRef()
    {
        $data = Category::with('children')
        // ->where('parent_id', null)->get();
        ->whereNull('parent_id')->get();

        $withParent = Category::with('parent')->whereNotNull('parent_id')->get();

        return response()->json([
            'withChildren' => $data,
            'withParent' => $withParent
        ]);
    }
}
