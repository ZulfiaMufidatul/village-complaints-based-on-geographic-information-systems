<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Kelurahan Bulakan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 13px;
        }

        .kop-image {
            width: 100%;
            height: auto;
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #000000;
        }

        .report-title {
            text-align: center;
            margin: 25px 0;
            padding: 15px 0;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 8px;
            border: 1px solid #90caf9;
        }

        .report-title h2 {
            font-size: 16px;
            font-weight: bold;
            color: #1565c0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .data-table thead {
            background: linear-gradient(135deg, #64b5f6 0%, #42a5f5 100%);
        }

        .data-table thead th {
            background: #42a5f5 !important;
            color: #ffffff !important;
            -webkit-print-color-adjust: exact;
            font-size: 10px;
            padding: 6px 4px;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f5f9ff;
        }

        .data-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .data-table tbody tr:hover {
            background-color: #e3f2fd;
        }

        .data-table tbody td {
            padding: 8px 6px;
            border: 1px solid #bbdefb;
            font-size: 9px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .status-active {
            background-color: #c8e6c9;
            color: #2e7d32;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: bold;
            text-align: center;
            font-size: 8px;
        }

        .status-inactive {
            background-color: #ffcdd2;
            color: #c62828;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: bold;
            text-align: center;
            font-size: 8px;
        }

        .status-pending {
            background-color: #fff3e0;
            color: #ef6c00;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: bold;
            text-align: center;
            font-size: 8px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            color: #666;
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        @media print {
            body {
                margin: 15px;
            }

            .data-table {
                font-size: 8px;
            }

            .data-table thead th {
                font-size: 9px;
                padding: 8px 6px;
            }

            .data-table tbody td {
                font-size: 8px;
                padding: 6px 4px;
            }
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
            background-color: #f5f9ff;
            border-radius: 8px;
            border: 1px dashed #90caf9;
        }

        .summary-info {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #4caf50;
        }

        .summary-info h4 {
            color: #2e7d32;
            margin-bottom: 5px;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Header dengan Kop Surat -->
    <div class="header">
        <img src="{{ asset('public/images/kopsurat.jpg') }}" alt="Kop Surat Kelurahan Bulakan" class="kop-image">
    </div>

    <!-- Judul Laporan -->
    <div class="report-title">
        <h2>Laporan Data Pengaduan Masyarakat</h2>
    </div>

    <!-- Informasi Summary -->
    @if (isset($data) && count($data) > 0)
        <div class="summary-info">
            <h4>Informasi Laporan</h4>
            <p><strong>Total Data:</strong> {{ count($data) }} pengaduan</p>
            <p><strong>Tanggal Cetak:</strong> {{ date('d F Y, H:i:s') }}</p>
        </div>
    @endif

    <!-- Tabel Data -->
    @if (isset($data) && count($data) > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Alamat</th>
                    <th>Kategori Infrastruktur</th>
                    <th>Kode Pengaduan</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Deskripsi</th>
                    <th>Longitude, Latitude</th>
                    <th>Status Permintaan</th>
                    <th>Status Pengaduan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr>
                        <td class="text-center font-bold">{{ $index + 1 }}</td>
                        <td>
                            {{ $item->hamlet ?? '-' }},
                            RT{{ $item->rt ?? '-' }}/RW{{ $item->rw ?? '-' }}
                        </td>
                        <td>{{ $item->infrastructure_category ?? '-' }}</td>
                        <td class="text-center font-bold">{{ $item->complaints_code ?? '-' }}</td>
                        <td>{{ $item->name ?? '-' }}</td>
                        <td>{{ $item->phone ?? '-' }}</td>
                        <td style="word-break: break-all;">{{ $item->email ?? '-' }}</td>
                        <td>{{ Str::limit($item->description ?? '-', 100) }}</td>

                        <td class="text-center">{{ $item->longitude ?? '-' }}, {{ $item->latitude ?? '-' }}</td>
                        <td class="text-center">
                            @if ($item->request_status == 'active')
                                <span class="status-active">Aktif</span>
                            @elseif($item->request_status == 'inactive')
                                <span class="status-inactive">Tidak Aktif</span>
                            @else
                                <span class="status-pending">{{ ucfirst($item->request_status ?? 'Pending') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($item->status_complaint == 'resolved')
                                <span class="status-active">Selesai</span>
                            @elseif($item->status_complaint == 'pending')
                                <span class="status-pending">Pending</span>
                            @elseif($item->status_complaint == 'in_progress')
                                <span class="status-pending">Diproses</span>
                            @else
                                <span class="status-inactive">{{ ucfirst($item->status_complaint ?? 'Baru') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <h3>Tidak Ada Data</h3>
            <p>Belum ada data pengaduan yang tersedia untuk ditampilkan.</p>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis pada {{ date('d F Y, H:i:s') }}</p>
        <p>Kelurahan Bulakan - Kecamatan Sukoharjo - Kabupaten Sukoharjo</p>
    </div>
</body>

</html>
