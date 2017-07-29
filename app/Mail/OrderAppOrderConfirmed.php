<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderAppOrderConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderdata)
    {
        $this->order = $orderdata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vendor.emails.orderconfirm')->subject( 'Order Confirmation-'.config('app.name') );
    }
}
