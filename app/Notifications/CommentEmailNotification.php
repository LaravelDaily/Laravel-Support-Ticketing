<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class CommentEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

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
                    ->subject('New comment on ticket '.$this->comment->ticket->title)
                    ->greeting('Hi,')
                    ->line('New comment on ticket '.$this->comment->ticket->title.':')
                    ->line('')
                    ->line(Str::limit($this->comment->comment_text, 500))
                    ->action('View full ticket', route(optional($notifiable)->id ? 'admin.tickets.show' : 'tickets.show', $this->comment->ticket->id))
                    ->line('Thank you')
                    ->line(config('app.name') . ' Team')
                    ->salutation(' ');
    }
}
