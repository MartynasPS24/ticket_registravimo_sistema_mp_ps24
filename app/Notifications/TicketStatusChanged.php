<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketStatusChanged extends Notification
{
    use Queueable;

    public function __construct(
        public Ticket $ticket,
        public string $oldStatus,
        public string $newStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Ticket #{$this->ticket->id} statusas pasikeitė")
            ->greeting("Sveiki, {$notifiable->name}!")
            ->line("Ticket „{$this->ticket->title}“ statusas pasikeitė.")
            ->line("Buvo: {$this->oldStatus}")
            ->line("Dabar: {$this->newStatus}")
            ->action('Peržiūrėti ticket', url(route('tickets.show', $this->ticket)));
    }
}
