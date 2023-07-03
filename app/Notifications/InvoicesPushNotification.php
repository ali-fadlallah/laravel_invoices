<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class InvoicesPushNotification extends Notification
{
    use Queueable;
    private $invoice_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice_id)
    {
        //
        $this->invoice_id = $invoice_id;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
            'id' => $this->invoice_id,
            'title' => "تم اضافه فاتوره جديده بواسطه: ",
            'user' => Auth::user()->name,

        ];
    }
}


// $url = 'http://127.0.0.1:8000/invoiceDetails/' . Crypt::encrypt($this->invoice_id);
// return (new MailMessage)
//     ->from('barrett@example.com', 'Barrett Blair')
//     ->line('The introduction to the notification.')
//     ->action('عرض الفاتوره', $url)
//     ->subject('فاتوره جديده')
//     ->line('Thank you for using our application!');
