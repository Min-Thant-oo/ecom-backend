<?php

namespace App\Jobs;

use App\Mail\ContactUsEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendContactUsEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $contactus;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($contactus)
    {
        $this->contactus = $contactus;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $adminEmail = User::where('usertype', 1)->value('email');
        Mail::to($adminEmail)->queue(new ContactUsEmail($this->contactus));
    }
}
