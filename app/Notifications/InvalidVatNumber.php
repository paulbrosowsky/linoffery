<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvalidVatNumber extends Notification
{
    use Queueable;   

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('linoffery: '.__('Invalid VAT-Number'))
                    ->greeting(__('Hello ').$notifiable->name.',')
                    ->line( __('Your companys VAT-number is ivalid. Please check your settings and add a proper VAT-Number.'))                    
                    ->salutation(__('Regards, Linoffery Team'));
    }   
}
