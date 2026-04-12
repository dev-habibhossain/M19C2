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
      $totalCustomers = Customer::count();
      
      $totalOrders = (clone $ordersQuery)->count();
      $totalOrdersAgain = Order::whereBetween('created_at', [$from, $to])->count();
      $totalRevenue = (clone $ordersQuery)->sum('grand_total');

      $totalPaid = Payment::whereHas('order', function($query) use ($from, $to){
        $query->betweenDates($from, $to);
      })->sum('amount');

      $totalDue = $totalRevenue - $totalPaid;

      // ToDo : i want to know that how that is worked?

      $revenueByStatus = (clone $ordersQuery)
        ->selectRaw('status, COUNT(*) as total_orders, SUM(grand_total) as total_revenue')
        ->groupBy('status')->get();

      return response()->json([
        "total_customers" => $totalCustomers,
        "total_orders" => $totalOrdersAgain,
        "total_revenue" => $totalRevenue,
        "total_paid" => $totalPaid,
        "total_due" => $totalDue,
        "revenue_status"=> $revenueByStatus
      ]);
    }
}
