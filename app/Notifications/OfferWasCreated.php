<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OfferWasCreated extends Notification
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
            'message' => 'hat neues Angebot',
            'price' => $this->offer->price,
            'tender_title' => $this->tender->title,
            'tender_id' => $this->tender->id,                       
        ];
    }

    // /**
    //  * Get the broadcast representation of the notification.
    //  *
    //  * @param  mixed  $notifiable
    //  * @return array
    //  */
    // public function toBroadcast($notifiable)
    // {
    //     return new NewOfferCreated($this->offer->id);
    // }
}
