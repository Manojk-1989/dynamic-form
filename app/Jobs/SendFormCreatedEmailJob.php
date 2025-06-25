<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\FormCreatedMail;
use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendFormCreatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        try {
            Log::info('📧 Sending email to admin');
            Mail::to('manojkumarka99@gmail.com')->send(new FormCreatedMail($this->form));
            Log::info('Email sent successfully');
        } catch (\Throwable $th) {
            Log::error('Error sending email: ' . $th->getMessage());
        }
    }
}
