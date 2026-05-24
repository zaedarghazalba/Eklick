<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Antrians;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class AntrianDipanggil extends Notification
{
    use Queueable;

    public function __construct(
        public readonly Antrians $antrian
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nomor Antrian Anda Dipanggil - Klinik PUI')
            ->greeting('Halo ' . $notifiable->name . '!')
->line('Nomor antrian Anda telah dipanggil.')
            ->line('Detail:')
            ->line('- Nomor Antrian: ' . $this->antrian->no_antrian)
            ->line('- Poli: ' . $this->antrian->poli)
            ->line('- Tanggal: ' . ($this->antrian->tanggal_daftar ? \Carbon\Carbon::parse($this->antrian->tanggal_daftar)->format('d-m-Y') : '-'))
            ->action('Lihat Detail', url('/antrianmu'))
            ->line('Silakan menuju loket pendaftaran untuk melanjutkan.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Antrian Dipanggil',
            'message' => 'Nomor antrian ' . $this->antrian->no_antrian . ' telah dipanggil',
            'antrian_id' => $this->antrian->id,
            'poli' => $this->antrian->poli,
        ];
    }
}