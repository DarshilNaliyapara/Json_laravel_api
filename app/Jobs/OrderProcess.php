<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $order;

    /**
     * Create a new job instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
        \Log::info("Processing Order: ".$order);
        $this->onConnection('database')
        ->onQueue('processing');
    }

    /**
     * Execute the job.
     */
    public function handle()

    {    
        sleep(2);
        \Log::info("order Shipped   ". $this->order);
  
    }
}
