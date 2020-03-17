<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Storage;

class OfferWasAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {           
        $this->order = $order;            
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail'];
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
        $attribute = 'shipper';
        
        if($notifiable->id === $this->order->carrier->id){
            $message = __('Please contact the shipper to clarify further details.');
            $attribute = 'carrier';
        }

        $path = Storage::disk('public')->url('pdf/orders/'.$this->order->custom_id.'_'.$attribute.'.pdf'); 
        
        // $path = public_path('pdf/orders/'.$this->order->custom_id.'_'.$attribute.'.pdf');  
        
        return (new MailMessage)
                    ->subject('linoffery: '.__('New order').' '. $this->order->custom_id)
                    ->greeting(__('Hello ').$notifiable->name.',')
                    ->line( __('You have a new order'))
                    ->action(__('Open order'), $url)
                    ->line(__('Attached you will find the overview and the contact details as PDF.'))
                    ->line( $message )
                    ->salutation(__('Regards, Linoffery Team'))
                    ->attach($path);
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
            'price' => $this->order->offer->price,
            'tender_title' => $this->order->tender->title,
            'order_id' => $this->order->id,                       
        ];
    }
}
