<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Form;

class SendFormCreatedEmailJob implements ShouldQueue
{
    use Queueable;

    protected $form;

    /**
     * Create a new job instance.
     */
    public function __construct(Form $form)
    {
        $this->form = $form;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to('admin@example.com')->send(new FormCreatedMail($this->form));
    }
}
