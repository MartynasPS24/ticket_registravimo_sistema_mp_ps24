<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCommentAdded extends Notification
{
    use Queueable;

    public function __construct(
        public Ticket $ticket,
        public TicketComment $comment
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Naujas komentaras ticket #{$this->ticket->id}")
            ->greeting("Sveiki, {$notifiable->name}!")
            ->line("Jūsų ticket'e „{$this->ticket->title}“ pridėtas naujas komentaras.")
            ->line("Komentarą parašė: {$this->comment->user?->name}")
            ->line("Komentaras:")
            ->line($this->comment->body)
            ->action('Peržiūrėti ticket', url(route('tickets.show', $this->ticket)))
            ->line('Ačiū, kad naudojatės sistema.');
    }
}
