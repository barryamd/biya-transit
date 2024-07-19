<?php

namespace App\Notifications;

use App\Models\Folder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FolderClosed extends Notification
{
    use Queueable;

    private Folder $folder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Folder $folder)
    {
        $this->folder = $folder;
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
            'title' => 'Dossier fermé',
            'message' => 'Le dossier numéro "' . $this->folder->number . '" a été fermé',
            'link' => route('folders.show', $this->folder->id),
        ];
    }
}
