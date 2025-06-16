<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pesanan Masuk</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f1f1f1; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px;">Halo {{ $kost->user->name }},</h2>

        <p style="font-size: 16px; margin-bottom: 10px;">Ada pesanan masuk untuk hunian <strong>{{ $kost->nama }}</strong>.</p>
        <p style="font-size: 16px; margin-bottom: 10px;">Detail pemesan:</p>
        <ul style="font-size: 16px; padding-left: 20px; margin-bottom: 20px;">
            <li><strong>Nama:</strong> {{ $user->name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Nomor Telepon:</strong> {{ $user->phone }}</li>
            <li><strong>Jenis Kelamin:</strong> {{ $user->gender }}</li>
        </ul>

        <p style="font-size: 16px; margin-bottom: 30px;">Silakan cek dashboard Anda untuk melihat detail dan konfirmasi pemesanan.</p>

    </div>
</body>

</html>