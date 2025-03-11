  <?php

  namespace App\Listeners;

  use App\Events\OrderPlaced;
  use Illuminate\Bus\Queueable;
  use Illuminate\Support\Facades\Log;
  use Illuminate\Support\Facades\Mail;
  use Illuminate\Support\Facades\Queue;
  use Illuminate\Queue\InteractsWithQueue;
  use Illuminate\Contracts\Queue\ShouldQueue;
  use Illuminate\Foundation\Events\Dispatchable;
  use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;

  class SendOrderConfirmation implements ShouldQueue
  {
    use Dispatchable;
    public $connection = 'database';
    public $queue = 'listeners';
    
    
      public function handle(OrderPlaced $event)
      {
        
        sleep(5);
        \Log::info("order Shipped");

      }
  }
