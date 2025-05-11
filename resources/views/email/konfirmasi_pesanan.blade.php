<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pesanan Disetujui</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <h2 style="color: #28a745;">Halo {{ $user->name }},</h2>

        <p style="font-size: 16px;">
            Anda sudah disetujui di tempat kost/kontrakan <strong>{{ $pembayaran->kost->nama }}</strong> 
            pada tanggal <strong>{{ \Carbon\Carbon::parse($pembayaran->tanggal_booking)->format('d M Y') }}</strong>.
        </p>

        <p style="font-size: 16px; color: #007bff;"><strong>Segera lakukan pembayaran.</strong></p>

        <hr style="margin: 30px 0;">

        <p style="font-size: 16px;">Terima kasih telah menggunakan layanan kami.</p>
        <p style="font-weight: bold;">Tim Admin</p>
    </div>
</body>
</html>
