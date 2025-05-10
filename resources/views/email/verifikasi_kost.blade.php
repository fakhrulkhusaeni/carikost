<!DOCTYPE html>
<html>
<head>
    <title>Notifikasi Verifikasi Hunian</title>
</head>
<body>
    <h2>Halo {{ $user->name }},</h2>
    <p>Selamat! Kost Anda dengan nama <strong>{{ $kost->nama }}</strong> telah berhasil diverifikasi oleh admin.</p>
    <p>Anda sekarang dapat menampilkan kost Anda kepada calon penyewa.</p>

    <p>Terima kasih telah menggunakan layanan kami.</p>

    <br>
    <p>Salam,</p>
    <p>Tim Admin</p>
</body>
</html>
