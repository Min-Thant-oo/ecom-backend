<?php

namespace App\Jobs;

use App\Mail\OrderConfirmationEmail;
use App\Models\User;
// use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Telegram\Bot\Laravel\Facades\Telegram;

class  SendOrderConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @param mixed $order
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pdf =  Pdf::loadView('admin.pdf.download_pdf', ['receipt' => $this->order]);
        $fileName = 'solarecom-receipt-' . $this->order->transaction_id . '-' . now()->format('d-m-Y') . '.pdf';


        Mail::send('admin.mail.order_confirmation', ['order' => $this->order], function ($message) use ($pdf, $fileName) {
            $message->to($this->order->user->email) 
                ->subject('Order Confirmation')
                ->attachData($pdf->output(), $fileName);
        });

    }
}