<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController
{
    public function summary(Request $request)
    {
      $from = $request->query("from");
      $to = $request->query("to");

      if(!$from || !$to){
        $to = now()->toDateString();
        $from = now()->subDays(30)->toDateString();
      }

      //Base query
      $ordersQuery = Order::query()->betweenDates($from, $to);


      //Total customer
      $totalCustomers = Customer::count();

      //Total orders
      $totalOrders = (clone $ordersQuery)->count();
      $totalRevenue = (clone $ordersQuery)->sum('grand_total');

      $totalPaid = Payment::whereHas('order', function($query) use ($from, $to){
        $query->betweenDates($from, $to);
      })->sum('amount');

      return response()->json([
        "total_customers" => $totalCustomers,
        "total_orders" => $totalOrders,
        "total_revenue" => $totalRevenue,
        "total_paid" => $totalPaid
      ]);
    }
}
