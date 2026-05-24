<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Medis - {{ $antrian->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #667eea;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: #667eea;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
            font-size: 11px;
        }

        .document-title {
            text-align: center;
            background: #667eea;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background: #f0f0f0;
            padding: 8px;
            font-weight: bold;
            color: #667eea;
            border-left: 4px solid #667eea;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        table td.label {
            width: 35%;
            font-weight: bold;
            background: #f9f9f9;
        }

        .vital-signs {
            display: table;
            width: 100%;
        }

        .vital-box {
            display: table-cell;
            width: 20%;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .vital-label {
            font-size: 10px;
            color: #666;
            display: block;
        }

        .vital-value {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            display: block;
            margin-top: 5px;
        }

        .content-box {
            border: 1px solid #ddd;
            padding: 10px;
            background: #fafafa;
            min-height: 60px;
        }

        .footer {
            margin-top: 40px;
            border-top: 2px solid #667eea;
            padding-top: 15px;
        }

        .signature-box {
            width: 45%;
            float: right;
            text-align: center;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }

        .page-break {
            page-break-after: always;
        }

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(102, 126, 234, 0.1);
            z-index: -1;
        }
    </style>
</head>
<body>

    <div class="watermark">ELECTRONIC KLINIK</div>

    <!-- Header -->
    <div class="header">
        <h1>ELECTRONIC KLINIK</h1>
        <p>Jl. Sudirman No. 10, Palembang, Indonesia</p>
        <p>Telp: +62 123 4567 890 | Email: info@electronic-klinik.com</p>
    </div>

    <!-- Document Title -->
    <div class="document-title">
        REKAM MEDIS ELEKTRONIK
    </div>

    <!-- Patient Identity -->
    <div class="section">
        <div class="section-title">IDENTITAS PASIEN</div>
        <table>
            <tr>
                <td class="label">Nama Lengkap</td>
                <td>{{ $antrian->nama }}</td>
                <td class="label">No. Rekam Medis</td>
                <td>#{{ str_pad($antrian->id, 6, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">No. KTP</td>
                <td>{{ $antrian->no_ktp }}</td>
                <td class="label">Jenis Kelamin</td>
                <td>{{ $antrian->jenis_kelamin }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Lahir</td>
                <td>{{ \Carbon\Carbon::parse($antrian->tgl_lahir)->isoFormat('D MMMM Y') }}</td>
                <td class="label">No. HP</td>
                <td>{{ $antrian->no_hp }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td colspan="3">{{ $antrian->alamat }}</td>
            </tr>
        </table>
    </div>

    <!-- Examination Info -->
    <div class="section">
        <div class="section-title">INFORMASI PEMERIKSAAN</div>
        <table>
            <tr>
                <td class="label">Poli/Klinik</td>
                <td>{{ $antrian->poli }}</td>
                <td class="label">Tanggal Pemeriksaan</td>
                <td>{{ $antrian->tanggal_periksa ? $antrian->tanggal_periksa->isoFormat('dddd, D MMMM Y - HH:mm') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Dokter Pemeriksa</td>
                <td>{{ $antrian->nama_dokter ?: '-' }}</td>
                <td class="label">Spesialisasi</td>
                <td>{{ $antrian->dokter_poli ? 'Dokter ' . $antrian->dokter_poli : '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Vital Signs -->
    @if($antrian->tekanan_darah || $antrian->nadi || $antrian->suhu_tubuh || $antrian->tinggi_badan || $antrian->berat_badan)
    <div class="section">
        <div class="section-title">TANDA-TANDA VITAL (VITAL SIGNS)</div>
        <div class="vital-signs">
            @if($antrian->tekanan_darah)
            <div class="vital-box">
                <span class="vital-label">Tekanan Darah</span>
                <span class="vital-value">{{ $antrian->tekanan_darah }}</span>
            </div>
            @endif
            @if($antrian->nadi)
            <div class="vital-box">
                <span class="vital-label">Nadi</span>
                <span class="vital-value">{{ $antrian->nadi }}</span>
            </div>
            @endif
            @if($antrian->suhu_tubuh)
            <div class="vital-box">
                <span class="vital-label">Suhu Tubuh</span>
                <span class="vital-value">{{ $antrian->suhu_tubuh }}</span>
            </div>
            @endif
            @if($antrian->tinggi_badan)
            <div class="vital-box">
                <span class="vital-label">Tinggi Badan</span>
                <span class="vital-value">{{ $antrian->tinggi_badan }} cm</span>
            </div>
            @endif
            @if($antrian->berat_badan)
            <div class="vital-box">
                <span class="vital-label">Berat Badan</span>
                <span class="vital-value">{{ $antrian->berat_badan }} kg</span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Anamnesa -->
    @if($antrian->keluhan_utama || $antrian->riwayat_penyakit)
    <div class="section">
        <div class="section-title">ANAMNESA (SUBJECTIVE)</div>
        @if($antrian->keluhan_utama)
        <strong>Keluhan Utama:</strong>
        <div class="content-box">{{ $antrian->keluhan_utama }}</div>
        @endif

        @if($antrian->riwayat_penyakit)
        <strong style="margin-top: 10px; display: block;">Riwayat Penyakit:</strong>
        <div class="content-box">{{ $antrian->riwayat_penyakit }}</div>
        @endif
    </div>
    @endif

    <!-- Pemeriksaan -->
    @if($antrian->pemeriksaan_fisik || $antrian->hasil_lab)
    <div class="section">
        <div class="section-title">PEMERIKSAAN (OBJECTIVE)</div>
        @if($antrian->pemeriksaan_fisik)
        <strong>Pemeriksaan Fisik:</strong>
        <div class="content-box">{{ $antrian->pemeriksaan_fisik }}</div>
        @endif

        @if($antrian->hasil_lab)
        <strong style="margin-top: 10px; display: block;">Hasil Laboratorium / Pemeriksaan Penunjang:</strong>
        <div class="content-box">{{ $antrian->hasil_lab }}</div>
        @endif
    </div>
    @endif

    <!-- Diagnosis & Plan -->
    <div class="section">
        <div class="section-title">DIAGNOSA & TERAPI (ASSESSMENT & PLAN)</div>

        <strong>Diagnosa:</strong>
        <div class="content-box">{{ $antrian->diagnosa }}</div>

        @if($antrian->tindakan_medis)
        <strong style="margin-top: 10px; display: block;">Tindakan Medis:</strong>
        <div class="content-box">{{ $antrian->tindakan_medis }}</div>
        @endif

        <strong style="margin-top: 10px; display: block;">Resep Obat:</strong>
        <div class="content-box" style="white-space: pre-wrap;">{{ $antrian->resep_obat }}</div>

        @if($antrian->anjuran)
        <strong style="margin-top: 10px; display: block;">Anjuran / Edukasi:</strong>
        <div class="content-box">{{ $antrian->anjuran }}</div>
        @endif

        @if($antrian->catatan_dokter)
        <strong style="margin-top: 10px; display: block;">Catatan Dokter:</strong>
        <div class="content-box">{{ $antrian->catatan_dokter }}</div>
        @endif
    </div>

    <!-- Footer / Signature -->
    <div class="footer">
        <div class="signature-box">
            <p>{{ $antrian->tanggal_periksa ? $antrian->tanggal_periksa->isoFormat('D MMMM Y') : \Carbon\Carbon::now()->isoFormat('D MMMM Y') }}</p>
            <div class="signature-line">
                <strong>{{ $antrian->nama_dokter ?: 'Dokter Pemeriksa' }}</strong><br>
                <small>{{ $antrian->dokter_poli ? 'Dokter ' . $antrian->dokter_poli : '' }}</small>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <!-- Document Info -->
    <div style="margin-top: 30px; font-size: 10px; color: #999; text-align: center;">
        <p>Dokumen ini digenerate secara elektronik oleh Electronic Klinik</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y HH:mm') }} WIB</p>
    </div>

</body>
</html>
