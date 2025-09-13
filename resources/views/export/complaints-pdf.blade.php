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
            font-size: 10px;
            line-height: 1.3;
            color: #333;
            margin: 10px;
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
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000000;
        }

        .report-title {
            text-align: center;
            margin: 20px 0;
            padding: 12px 0;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 6px;
            border: 1px solid #90caf9;
        }

        .report-title h2 {
            font-size: 14px;
            font-weight: bold;
            color: #1565c0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            overflow: hidden;
            table-layout: fixed;
        }

        .data-table thead {
            background: linear-gradient(135deg, #64b5f6 0%, #42a5f5 100%);
        }

        .data-table thead th {
            background: #42a5f5 !important;
            color: #ffffff !important;
            -webkit-print-color-adjust: exact;
            font-size: 7px;
            padding: 6px 3px;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }

        /* Lebar kolom yang disesuaikan */
        .data-table th:nth-child(1) { width: 3%; } /* No */
        .data-table th:nth-child(2) { width: 15%; } /* Foto */
        .data-table th:nth-child(3) { width: 8%; } /* Kode */
        .data-table th:nth-child(4) { width: 8%; } /* Nama */
        .data-table th:nth-child(5) { width: 10%; } /* Alamat */
        .data-table th:nth-child(6) { width: 8%; } /* Kategori */
        .data-table th:nth-child(7) { width: 8%; } /* Telepon */
        .data-table th:nth-child(8) { width: 14%; } /* Email */
        .data-table th:nth-child(9) { width: 12%; } /* Deskripsi */
        .data-table th:nth-child(10) { width: 8%; } /* Koordinat */
        .data-table th:nth-child(11) { width: 7%; } /* Status Permintaan */
        .data-table th:nth-child(12) { width: 7%; } /* Status Pengaduan */

        .data-table tbody tr:nth-child(even) {
            background-color: #f5f9ff;
        }

        .data-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .data-table tbody td {
            padding: 4px 2px;
            border: 1px solid #bbdefb;
            font-size: 7px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .data-table img {
            width: 90px;
            object-fit: cover;
            border-radius: 3px;
        }

        .status-active {
            background-color: #c8e6c9;
            color: #2e7d32;
            padding: 2px 4px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            font-size: 7px;
            display: block;
            margin: 1px 0;
        }

        .status-inactive {
            background-color: #ffcdd2;
            color: #c62828;
            padding: 2px 4px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            font-size: 7px;
            display: block;
            margin: 1px 0;
        }

        .status-pending {
            background-color: #fff3e0;
            color: #ef6c00;
            padding: 2px 4px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            font-size: 7px;
            display: block;
            margin: 1px 0;
        }

        .footer {
            margin-top: 25px;
            text-align: right;
            color: #666;
            font-size: 8px;
        }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
            background-color: #f5f9ff;
            border-radius: 6px;
            border: 1px dashed #90caf9;
        }

        .summary-info {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            border-left: 4px solid #4caf50;
        }

        .summary-info h4 {
            color: #2e7d32;
            margin-bottom: 4px;
            font-size: 11px;
        }

        .summary-info p {
            font-size: 9px;
            margin-bottom: 2px;
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

        /* Style khusus untuk koordinat */
        .coordinate-text {
            font-size: 7px;
            line-height: 1.2;
            word-break: break-all;
        }

        /* Style untuk email yang panjang */
        .email-text {
            font-size: 7px;
            word-break: break-all;
            line-height: 1.1;
        }

        /* Style untuk deskripsi */
        .description-text {
            font-size: 7px;
            line-height: 1.2;
            text-align: justify;
        }

        @media print {
            body {
                margin: 8px;
                font-size: 8px;
            }

            .data-table thead th {
                font-size: 7px;
                padding: 4px 2px;
            }

            .data-table tbody td {
                font-size: 6px;
                padding: 3px 1px;
            }

            .status-active, .status-inactive, .status-pending {
                font-size: 5px;
                padding: 1px 2px;
            }

            .coordinate-text, .email-text {
                font-size: 5px;
            }

            .description-text {
                font-size: 6px;
            }
        }

        /* Responsive untuk layar kecil */
        @media (max-width: 768px) {
            .data-table {
                font-size: 6px;
            }
            
            .data-table thead th {
                font-size: 6px;
                padding: 4px 1px;
            }
            
            .data-table tbody td {
                font-size: 5px;
                padding: 2px 1px;
            }
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
                    <th>Foto</th>
                    <th>Kode<br>Pengaduan</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Kategori<br>Infrastruktur</th>
                    <th>Telepon</th>
                    <th>Email</th>
                    <th>Deskripsi</th>
                    <th>Koordinat<br>(Lng, Lat)</th>
                    <th>Status<br>Permintaan</th>
                    <th>Status<br>Pengaduan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $index => $item)
                    <tr>
                        <td class="text-center font-bold">{{ $index + 1 }}</td>
                        <td class="text-center">
                            @if ($item->photo)
                                <img src="{{ public_path('storage/' . $item->photo) }}" alt="Foto">
                            @else
                                <span style="font-size: 7px; color: #999;">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="text-center font-bold">{{ $item->complaints_code ?? '-' }}</td>
                        <td>{{ $item->name ?? '-' }}</td>
                        <td style="font-size: 7px;">
                            {{ $item->hamlet ?? '-' }}<br>
                            RT{{ $item->rt ?? '-' }}/RW{{ $item->rw ?? '-' }}
                        </td>
                        <td style="font-size: 7px;">{{ $item->infrastructure_category ?? '-' }}</td>
                        <td style="font-size: 7px;">{{ $item->phone ?? '-' }}</td>
                        <td class="email-text">{{ $item->email ?? '-' }}</td>
                        <td class="description-text">{{ Str::limit($item->description ?? '-', 80) }}</td>
                        <td class="coordinate-text text-center">
                            @if($item->longitude && $item->latitude)
                                {{ number_format($item->longitude, 6) }},<br>{{ number_format($item->latitude, 6) }}
                            @else
                                -
                            @endif
                        </td>
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