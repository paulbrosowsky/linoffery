<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TenderRunOut extends Notification implements ShouldQueue
{
    use Queueable;

    protected $tender;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($tender)
    {
        $this->tender = $tender;
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
        return (new MailMessage)
                    ->greeting(__('Hello ').$this->tender->user->name. ',')
                    ->line(__('Your tender "'). $this->tender->title .__('" has run out.'))
                    ->action(__('Open tender'), config('app.url').'/tenders/'.$this->tender->id)
                    ->line(__('If you want to publish this tender again, please use a copy function right on your teders view.'));
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
            'message' => __('Your tender has run out.'),
            'tender_title' => $this->tender->title,
            'tenderId' => $this->tender->id
        ];
    }
}
