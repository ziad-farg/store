<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
        // $channels = ['database'];

        // if ($notification_references['order_created']['mail'] ?? false) {
        //     $channels[] = 'mail';
        // }
        // if ($notification_references['order_created']['sms'] ?? false) {
        //     $channels[] = 'vonage';
        // }
        // if ($notification_references['order_created']['broadcast'] ?? false) {
        //     $channels[] = 'broadcast';
        // }

        // return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Created Successfully')
            ->greeting("Hello! {$notifiable->name}")
            ->line("A new Order #{$this->order->number} created by {$this->order->billingAddress->full_name} is Successfully.")
            ->action('View Order', route('home'))
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
        ];
    }
}
