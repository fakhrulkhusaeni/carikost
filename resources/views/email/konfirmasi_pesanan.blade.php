<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pesanan</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px;">Halo {{ $user->name }},</h2>

        <p style="font-size: 16px; line-height: 1.6;">
            Selamat! Anda telah disetujui untuk menempati kost atau kontrakan <strong>{{ $pembayaran->kost->nama }}</strong> 
            pada tanggal <strong>{{ \Carbon\Carbon::parse($pembayaran->tanggal_booking)->locale('id')->translatedFormat('d F Y') }}</strong>.
        </p>

        <p style="font-size: 16px; margin-bottom: 30px;">Silakan Melakukan Pembayaran Sekarang</p>

    </div>
</body>
</html>
