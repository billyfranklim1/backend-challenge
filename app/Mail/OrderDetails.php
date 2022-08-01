<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDetails extends Mailable
{
    use Queueable, SerializesModels;

    public $order_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order = Order::with(['customer', 'products'])->find($this->order_id);

        $totalOrder = 0;
        foreach ($order->products as $product) {
            $totalOrder += $product->pivot->quantity * $product->price;
        }


        return $this
            ->subject($order->customer->name . ' - Detalhes do Pedido')
            ->view('emails.order-details')
            ->with([
                'order' => $order,
                'totalOrder' => $totalOrder,
            ]);
    }
}
