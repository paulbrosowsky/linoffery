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
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {          
        $message = __('In the further course, the forwarding company will contact you to clarify the details.');    
        $url = config('app.url').'/orders/'.$this->order->id;
        
        if($notifiable->id === $this->order->carrier->id){
            $message = __('Please contact the shipper to clarify further details.');
        }

        return (new MailMessage)
                    ->subject('linoffery: '.__('New order').' '. $this->order->custom_id)
                    ->greeting(__('Hello ').$notifiable->name.',')
                    ->line( __('You have a new order'))
                    ->action(__('Open order'), $url)
                    ->line(__('Attached you will find the overview and the contact details as PDF.'))
                    ->line( $message )
                    ->attach(storage_path('app/public/pdf/orders/'.$this->order->custom_id.'.pdf'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {  
        return [            
            'message' => __('You have a new order'),
            'price' => $this->offer->price,
            'tender_title' => $this->offer->tender->title,
            'order_id' => $this->order->id,                       
        ];
    }
}
