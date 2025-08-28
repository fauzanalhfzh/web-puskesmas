<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tiket Antrian {{ $pendaftaran->nomor_antrian }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .tiket {
            border: 2px dashed #333;
            padding: 20px;
            width: 300px;
            text-align: center;
        }

        .nomor {
            font-size: 36px;
            font-weight: bold;
            margin: 20px 0;
        }

        .sub-title {
            font-size: 28px;
            font-weight: semibold;
            margin: 12px 0;
        }

        .detail {
            font-size: 14px;
            margin-top: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="tiket">
        <h2>Puskesmas Citangkil II</h2>
        <p>Nomor Antrian</p>
        <div class="nomor">{{ $pendaftaran->nomor_antrian }}</div>
        <div class="sub-title">{{ $pendaftaran->tanggal_kunjungan }}</div>
        <div class="sub-title">{{ $pendaftaran->jalur }}</div>
        <div class="detail">
            <p>Nama: {{ $pasien->nama_lengkap }}</p>
            <p>NIK: {{ $pasien->nik }}</p>
            <p>Jenis Kelamin: {{ $pasien->Jenis_Kelamin }}</p>
            <p>Tanggal Lahir: {{ $pasien->tanggal_lahir }}</p>
            <p>Alamat: {{ $pasien->alamat }}</p>
            <p>Telepon: {{ $pasien->no_telepon }}</p>
            <p>Poli: {{ $poli->nama_poli }}</p>
            <p>Tanggal: {{ \Carbon\Carbon::parse($pendaftaran->tanggal_kunjungan)->format('d M Y') }}</p>
            <p>Jalur: {{ ucfirst($pendaftaran->jalur) }}</p>
        </div>
    </div>
</body>

</html>