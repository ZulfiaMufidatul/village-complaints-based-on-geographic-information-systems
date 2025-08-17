<?php

namespace App\Filament\Resources\ComplaintResource\Pages;

use App\Filament\Resources\ComplaintResource;
use App\Mail\ComplaintStatusUpdated;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class EditComplaint extends EditRecord
{
    protected static string $resource = ComplaintResource::class;

    protected ?string $oldRequestStatus = null;
    protected ?string $oldStatusComplaint = null;

    public function getTitle(): string
    {
        return 'Proses Aduan';
    }

    public function getBreadcrumb(): string
    {
        return 'Proses';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
            ->label('Hapus'),
            Action::make('back')
                ->label('Kembali')
                ->color('primary')
                ->url(ComplaintResource::getUrl('index'))
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
            Actions\Action::make('cancel')
                ->label('Batal')
                ->color('gray')
                ->outlined()
                ->url($this->getResource()::getUrl('index')),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function beforeSave(): void
    {
        // Simpan status lama sebelum disimpan
        $this->oldRequestStatus = $this->record->getOriginal('request_status');
        $this->oldStatusComplaint = $this->record->getOriginal('status_complaint');
    }

    protected function afterSave(): void
    {
        $complaint = $this->record;

        // ambil status baru
        $newRequestStatus = $complaint->request_status;
        $newStatusComplaint = $complaint->status_complaint;

        // cek apakah status berubah
        $statusChanged = (
            $this->oldRequestStatus !== $newRequestStatus ||
            $this->oldStatusComplaint !== $newStatusComplaint
        );

        // Hanya kirim email jika ada email yang diisi
        if ($statusChanged && $complaint->email) {
            Mail::to($complaint->email)->send(new ComplaintStatusUpdated($complaint));
        }

        // Notifikasi whatsapp (Twilio)
        if ($statusChanged && $complaint->phone) {
        try {
            $sid = config('services.twilio.sid');
            $token = config('services.twilio.token');
            $from = config('services.twilio.whatsapp_from');

            $client = new Client($sid, $token);

             // Sandbox: override nomor untuk testing
            $toNumber = app()->environment('local') || app()->environment('development')
                ? '+62895422622021' // Nomor kamu yang sudah join Twilio Sandbox
                : preg_replace('/^0/', '+62', $complaint->phone); // Nomor pelapor diubah ke format internasional

            $client->messages->create(
               'whatsapp:' . $toNumber,
                [
                    'from' => 'whatsapp:' . $from,
                    'body' => "Halo {$complaint->name}, status aduan Anda telah diperbarui.\n\n" .
                              "Kode Aduan: {$complaint->complaints_code}\n" .
                              "Status Permintaan: " . ucfirst($complaint->request_status) . "\n" .
                              "Status Aduan: " . ucfirst($complaint->status_complaint)
                ]
            );
        } catch (\Exception $e) {
            Log::error("Gagal kirim WhatsApp: " . $e->getMessage());
        }
    }
    }
}
