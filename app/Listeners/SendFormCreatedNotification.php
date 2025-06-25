<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendFormCreatedEmailJob;
use Illuminate\Support\Facades\Log;
use App\Events\FormCreated;

class SendFormCreatedNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(FormCreated $event): void
    {
        Log::info('SendFormCreatedNotification listener triggered for form id: ' . $event->form->id);
    
         SendFormCreatedEmailJob::dispatch($event->form);
         Log::info('SendFormCreatedNotification listener triggered for form id: ' . $event->form->id);
    
    }
}
