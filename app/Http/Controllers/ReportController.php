<?php

namespace App\Http\Controllers;

use App\Models\Order;
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


      //Total sales

    }
}
