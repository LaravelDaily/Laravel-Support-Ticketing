<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TicketTelegram extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        // dd($notifiable);
        // dd($this);
        $url = ('localhost:8000/admin/tickets/'. $notifiable->id);
        // dd($url);

        return TelegramMessage::create()
            // Optional recipient user id.
            // ->to($notifiable->telegram_user_id)
            ->to('-1001437354884')
            // Markdown supported.
            ->content("Hello there!\nYour invoice has been *PAID*". $url)
            
            // (Optional) Blade template for the content.
            // ->view('notification', ['url' => $url])
            
            // // (Optional) Inline Buttons
            ->button('View Ticket', $url)
            ->button('Download Invoice', $url);
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
            //
        ];
    }
}
