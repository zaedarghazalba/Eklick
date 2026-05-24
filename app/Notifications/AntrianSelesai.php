<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Antrians;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

final class AntrianSelesai extends Notification
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
            ->subject('Pemeriksaan Selesai - Klinik PUI')
            ->greeting('Terima kasih, ' . $notifiable->name . '!')
            ->line('Pemeriksaan Anda telah selesai.')
            ->line('Detail:')
            ->line('• Nomor Antrian: ' . $this->antrian->no_antrian)
            ->line('• Poli: ' . $this->antrian->poli)
            ->line('• Diagnosa: ' . ($this->antrian->diagnosa ?? '-'))
            ->line('• Catatan: ' . ($this->antrian->catatan_dokter ?? '-'))
            ->action('Lihat Riwayat', url('/antrianmu'))
            ->line('Semoga lekas sembuh! Salam dari Klinik PUI.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Pemeriksaan Selesai',
            'message' => 'Pemeriksaan untuk antrian ' . $this->antrian->no_antrian . ' telah selesai',
            'antrian_id' => $this->antrian->id,
            'diagnosa' => $this->antrian->diagnosa,
        ];
    }
}