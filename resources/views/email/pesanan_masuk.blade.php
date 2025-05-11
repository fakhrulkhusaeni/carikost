<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f1f1f1; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px;">
        <h2 style="color: #007bff;">Halo {{ $kost->user->name }},</h2>

        <p style="font-size: 16px;">Ada pesanan baru untuk kost <strong>{{ $kost->nama }}</strong>.</p>
        <p style="font-size: 16px;">Dipesan oleh: <strong>{{ $user->name }}</strong></p>

        <p style="font-size: 16px;">Silakan cek dashboard Anda untuk melihat detail dan konfirmasi pemesanan.</p>

        <br>
        <p>Terima kasih,</p>
        <p><strong>Tim Admin</strong></p>
    </div>
</body>
</html>
