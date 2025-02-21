<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Pembelian;

class OrderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(Pembelian $order)
    {
        $this->order = $order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Confirmation - MogoOhana #' . $this->order->nomer_order,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order_notification',
            with: [
                'order' => $this->order,
                'orderDetails' => $this->order->details,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        $attachments = [];

        // Attach payment proof if available
        if ($this->order->bukti_pembayaran) {
            $attachments[] = [
                'path' => storage_path('app/public/' . $this->order->bukti_pembayaran),
                'as' => 'payment_proof.jpg',
                'mime' => 'image/jpeg',
            ];
        }

        return $attachments;
    }
}
