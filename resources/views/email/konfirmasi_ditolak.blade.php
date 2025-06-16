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
            Mohon maaf, Anda telah ditolak untuk menempati kost atau kontrakan <strong>{{ $pembayaran->kost->nama }}</strong>
            pada tanggal <strong>{{ \Carbon\Carbon::parse($pembayaran->tanggal_booking)->locale('id')->translatedFormat('d F Y') }}</strong>.
        </p>

        @if($pembayaran->status_konfirmasi == 'Ditolak' && $pembayaran->catatan_penolakan)
        <div style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; margin-top: 20px;">
            <strong>Catatan Penolakan:</strong>
            <p style="margin-top: 8px;">{{ $pembayaran->catatan_penolakan }}</p>
        </div>
        @endif

    </div>
</body>

</html>