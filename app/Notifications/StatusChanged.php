<?php

namespace App\Notifications;

use App\Modules\Filing\Models\Filing;
use App\Modules\Review\Models\Comment;
use App\Modules\User\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StatusChanged extends Notification
{
    use Queueable;
    public $filing;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Filing $filing)
    {
        $this->filing = $filing;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'message' => 'Filing ' . $this->filing->id . ' status has changed from '. $this->filing->getOriginal('status') . ' to ' . $this->filing->status,
            'admin' => $notifiable,
            'link' => "/editor/" . $this->filing->id
        ];
    }
}
