<?php

namespace App\Http\Controllers;

use App\Jobs\OrderProcess;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use App\Listeners\SendOrderConfirmation;

class TestController extends Controller
{

    public function search(Request $request)
    {
        $input = $request->inputdata;
        dd($input);
    }


    public function test2()
    {
        $order = "item";
        OrderProcess::dispatch($order); 
        // \Artisan::call('schedule:run'); 
        Log::info('Order is ready');
        return response()->json(['message' => 'Order placed successfully']);
    }
   

}
