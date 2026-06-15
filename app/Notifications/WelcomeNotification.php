<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $restaurantName = 'Restaurant Istanbul';

    /**
     * Create a new notification instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bienvenue au Restaurant Istanbul ! 🎉')
            ->greeting('Merhaba ' . $this->user->name . ' !')
            ->line('Nous sommes ravis de vous accueillir dans notre famille Istanbul.')
            ->line('Découvrez la richesse de la cuisine turque authentique préparée avec passion par nos chefs.')
            ->action('Découvrir notre menu', url('/menu'))
            ->line('**Offre spéciale :** 10% de réduction sur votre première commande avec le code : **BIENVENUE10**')
            ->line('Nous avons hâte de vous servir les meilleurs plats turcs de la ville !')
            ->salutation('L\'équipe du Restaurant Istanbul');
    }

    /**
     * Get the array representation of the notification (for database).
     */
    public function toArray($notifiable): array
    {
        return [
            'title' => 'Bienvenue au Restaurant Istanbul !',
            'message' => 'Merci de vous être inscrit. Découvrez nos délicieux plats turcs.',
            'type' => 'welcome',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
        ];
    }
}