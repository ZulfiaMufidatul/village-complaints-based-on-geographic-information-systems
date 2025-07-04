<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ComplaintCreatedNotification extends Notification
{
    use Queueable;

    protected $complaint;
    /**
     * Create a new notification instance.
     */
    public function __construct($complaint)
    {
        $this->complaint = $complaint;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Aduan Anda Berhasil Dikirim')
            ->greeting('Halo ' . $this->complaint->name . ',')
            ->line('Terima kasih telah mengirimkan aduan.')
            ->line('Kode Aduan Anda: ' . $this->complaint->complaints_code)
            ->line('Kategori: ' . $this->complaint->infrastructure_category)
            ->line('Deskripsi: ' . $this->complaint->description)
            ->line('Kami akan memproses aduan Anda secepatnya.')
            ->salutation('Salam, Tim Pengaduan Infrastruktur');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
