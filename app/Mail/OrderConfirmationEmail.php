<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Mail\Mailables\Attachment;

class OrderConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Order Confirmation #{{!!$order->transaction_id!!}}',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'admin.mail.order_confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *  
     * @return array
     */
    public function attachments()
    {
        // return [];
        // $receipt = ['receipt' => $this->order];
        // $pdf = Pdf::loadView('admin.pdf.download_pdf', $receipt);
        // $todayDate = Carbon::now()->format('d-m-Y');
        // // return $pdf->output();

        // // Attach the PDF to the email
        // $filename = 'receipt-' . $this->order->transaction_id . '-' . now()->format('d-m-Y') . '.pdf';
        // return [
        //     [
        //         'data' => $pdf,
        //         'name' => $filename,
        //         'options' => ['mime' => 'application/pdf'],
        //         'attachment' => $this->attachData($pdf, $filename, ['mime' => 'application/pdf']),
        //     ],
        // ];

        // return [
        //     Attachment::fromPath($this->order['attachment'])
        //         ->as('receipt-' . $this->order->transaction_id . '-' . now()->format('d-m-Y') . '.pdf')
        //         ->withMime('application/pdf')
        // ];

        $data = [
            'order' => $this->order,
            // Add any additional dynamic data you need
        ];

        $pdf = PDF::loadView('admin.mail.order_confirmation', $data);

        // $fileName = 'receipt-' . $this->order->transaction_id . '-' . now()->format('d-m-Y') . '.pdf';

        return [
            'invoice.pdf' => $pdf->output(),
        ];
    }

}
