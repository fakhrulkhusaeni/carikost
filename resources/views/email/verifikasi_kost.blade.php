<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Hunian</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f1f1f1; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px;">Halo {{ $user->name }},</h2>

        <p style="font-size: 16px; margin-bottom: 10px;">
            Selamat! Hunian Anda telah berhasil diverifikasi oleh admin.
        </p>

        <p style="font-size: 16px; margin-bottom: 10px;">
            Berikut adalah detail hunian Anda:
        </p>

        <ul style="font-size: 16px; padding-left: 20px; margin-bottom: 20px; line-height: 1.6;">
            <li><strong>Nama Hunian:</strong> {{ $kost->hunian->nama }}</li>
            <li><strong>Deskripsi:</strong> {{ $kost->hunian->deskripsi }}</li>
            <li><strong>Tipe Hunian:</strong> {{ $kost->type }}</li>
            <li><strong>Total Kamar:</strong> {{ $kost->jumlah_kamar }}</li>
            <li><strong>Lokasi Kecamatan:</strong> {{ $kost->hunian->location }}</li>
            <li><strong>Alamat Lengkap:</strong> {{ $kost->hunian->alamat }}</li>
        </ul>

        <p style="font-size: 16px; margin-bottom: 30px;">
            Anda sekarang dapat menampilkan hunian Anda kepada calon penyewa.
        </p>

    </div>
</body>

</html>