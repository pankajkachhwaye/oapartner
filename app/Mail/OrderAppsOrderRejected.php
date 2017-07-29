<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderAppsOrderRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $reason;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderdata,$reasondata)
    {
        $this->order = $orderdata;
        $this->reason = $reasondata;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vendor.emails.orderreject')->subject( 'Order Rejected-'.config('app.name') );;
    }
}
