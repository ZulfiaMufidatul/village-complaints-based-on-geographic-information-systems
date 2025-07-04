<x-mail::message>
# Hai, {{ $complaint->name }}

Status aduan Anda telah diperbarui.

**Kode Aduan:** {{ $complaint->complaints_code }}  
**Kategori:** {{ $complaint->infrastructure_category }}  
**Status Sekarang:** {{ ucfirst($complaint->status_complaint) }}

@component('mail::button', ['url' => route('complaints.track', ['complaints_code' => $complaint->complaints_code])])
Lihat Detail Aduan
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
