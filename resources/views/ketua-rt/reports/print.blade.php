<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title></title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.5cm 2cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            line-height: 1.3;
            color: #000;
            background: white;
            position: relative;
            height: 100%;
        }

        .container {
            width: 100%;
            margin: 0;
            padding: 0;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 3px solid #000;
            padding-bottom: 5px;
        }

        .header h1 {
            font-size: 13pt;
            font-weight: bold;
            margin: 3px 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 12pt;
            font-weight: bold;
            margin: 3px 0;
            text-transform: uppercase;
        }

        .header p {
            font-size: 10pt;
            margin: 2px 0;
        }

        .content {
            margin-top: 5px;
        }

        .section {
            margin-bottom: 10px;
        }

        .section-title {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 4px 5px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
            padding: 6px 5px;
            font-size: 10pt;
        }
        
        /* Khusus untuk kolom uraian tugas agar text wrap dengan baik */
        td {
            white-space: normal;
            line-height: 1.4;
        }
        
        /* Styling khusus untuk foto */
        td img {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }

        /* Signature section mengikuti alur dokumen (tidak fixed) agar tidak dobel */
        .signature-section {
            page-break-inside: avoid;
            break-inside: avoid;
            margin-top: 20px;
        }

        @media print {
            .signature-section {
                page-break-inside: avoid;
            }
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mb-1 {
            margin-bottom: 10px;
        }

        .mb-2 {
            margin-bottom: 20px;
        }

        /* Print styles */
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .no-print {
                display: none !important;
            }

            .page-break {
                page-break-after: always;
            }

            /* Supaya tabel rapi saat pindah halaman */
            table { page-break-inside: auto; }
            /* JANGAN gunakan display: table-header-group agar header TIDAK auto-repeat */
            thead { display: none; } /* Sembunyikan thead di halaman 2+ */
            tfoot { display: table-row-group; }
            tr { page-break-inside: avoid; page-break-after: auto; }
            
            /* Tampilkan thead HANYA di halaman pertama */
            table:first-of-type thead { display: table-header-group; }
        }

        /* Button styles */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
        }

        .print-button:hover {
            background-color: #0056b3;
        }

        .back-button {
            position: fixed;
            top: 20px;
            right: 140px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background-color: #545b62;
        }
    </style>
</head>
<body>
    <!-- Buttons -->
    <a href="{{ route('ketua-rt.reports.show', $report) }}" class="back-button no-print">← Kembali</a>
    <button onclick="window.print()" class="print-button no-print">🖨️ Print</button>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>LAPORAN BULAN {{ strtoupper(\Carbon\Carbon::parse($report->month . '-01')->locale('id')->isoFormat('MMMM YYYY')) }}</h1>
            <h2>PELAKSANAAN TUGAS DAN FUNGSI KETUA RUKUN TETANGGA (RT) {{ $report->rt_code }}</h2>
            <h2>KELURAHAN {{ strtoupper(str_replace('KELURAHAN ', '', $kelurahan_name)) }}</h2>
        </div>

        <!-- Content -->
        <div class="content">
            <table id="report-table">
                <thead>
                    <tr>
                        <th width="8%" style="text-align: center;">NO</th>
                        <th width="15%" style="text-align: center;">TANGGAL</th>
                        <th width="52%" style="text-align: center;">URAIAN TUGAS DAN FUNGSI YANG DILAKSANAKAN</th>
                        <th width="25%" style="text-align: center;">KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $activities = [];
                        if ($report->activities) {
                            $decoded = json_decode($report->activities, true);
                            if (is_array($decoded)) {
                                $activities = $decoded;
                            } else {
                                // Fallback untuk format lama (string)
                                $activitiesText = explode("\n", trim($report->activities));
                                foreach($activitiesText as $act) {
                                    if(trim($act)) {
                                        $activities[] = ['date' => '', 'task' => trim($act), 'note' => '', 'photo' => ''];
                                    }
                                }
                            }
                        }
                        
                        $no = 1;
                    @endphp
                    
                    @forelse($activities as $activity)
                        <tr>
                            <td class="text-center" style="vertical-align: top; padding-top: 6px;">{{ $no++ }}</td>
                            <td class="text-center" style="vertical-align: top; padding-top: 6px;">
                                @if(!empty($activity['date']))
                                    {{ \Carbon\Carbon::parse($activity['date'])->format('d/m/Y') }}
                                @endif
                            </td>
                            <td style="vertical-align: top; padding-top: 6px;">{{ $activity['task'] ?? '' }}</td>
                            <td style="vertical-align: top; padding-top: 6px;">{{ $activity['note'] ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center">1</td>
                            <td></td>
                            <td>Tidak ada kegiatan tercatat</td>
                            <td></td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <!-- Baris kosong untuk memastikan garis bawah tabel tertutup pada halaman terakhir -->
                    <tr>
                        <td colspan="4" style="height:0; padding:0; border-top:1px solid #000; border-bottom:1px solid #000;"></td>
                    </tr>
                </tfoot>
            </table>

            <!-- Signature Section - Muncul sekali di akhir dokumen -->
            <div class="signature-section">                
                <table style="border: none; width: 100%; margin-top: 0;">
                    <tr style="border: none;">
                        <td style="border: none; width: 50%; vertical-align: top; padding: 0; padding-left: 50px;">
                            <div>
                                <p style="margin: 0 0 2px 0; font-size: 10pt;">Mengetahui/menyetujui</p>
                                <p style="margin: 0 0 2px 0; font-size: 10pt;"><strong>LURAH {{ strtoupper(str_replace('KELURAHAN ', '', $kelurahan_name)) }}</strong></p>
                                <p style="margin: 0 0 60px 0; font-size: 10pt;">&nbsp;</p>
                                <p style="margin: 0; font-size: 10pt;"><strong>{{ strtoupper($lurah_name) }}</strong></p>
                            </div>
                        </td>
                        <td style="border: none; width: 50%; vertical-align: top; padding: 0; padding-right: 50px;">
                            <div style="float: right;">
                                <p style="margin: 0 0 2px 0; font-size: 10pt;">Balikpapan, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                                <p style="margin: 0 0 2px 0; font-size: 10pt;"><strong>KETUA RT {{ $report->rt_code }}</strong></p>
                                <p style="margin: 0 0 60px 0; font-size: 10pt;">&nbsp;</p>
                                <p style="margin: 0; font-size: 10pt;"><strong>{{ strtoupper($report->user->name) }}</strong></p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Auto print on load (optional, uncomment if needed)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
