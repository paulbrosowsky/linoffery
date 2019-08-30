<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferWasOutbidded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $tender;
    protected $offer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tender, $offer)
    {        
        $this->tender = $tender;
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
  

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [            
            'message' => __('You have been outbid'),
            'price' => $this->offer['price'],
            'tender_title' => $this->tender->title,
            'tender_id' => $this->tender->id,                       
        ];
    }
}
