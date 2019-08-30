<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferWasAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;
    protected $offer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $offer)
    {        
        $this->order = $order;
        $this->offer = $offer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    // /**
    //  * Get the mail representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return \Illuminate\Notifications\Messages\MailMessage
    //  */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [            
            'message' => __('You have new order'),
            'price' => $this->offer->price,
            'tender_title' => $this->offer->tender->title,
            'order_id' => $this->order->id,                       
        ];
    }
}
