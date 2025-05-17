<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pembayaran Masuk</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
        <h2 style="margin-bottom: 20px;">Pembayaran Masuk</h2>

        <p style="font-size: 16px; line-height: 1.6;">Halo {{ $riwayat->kost->user->name }},</p>

        <p style="font-size: 16px; line-height: 1.6;">
            Pencari Hunian baru saja melakukan pembayaran dengan detail berikut:
        </p>

        <ul style="font-size: 16px; line-height: 1.6; padding-left: 20px; margin-top: 10px; margin-bottom: 20px;">
            <li><strong>Nama Pencari:</strong> {{ $riwayat->user->name }}</li>
            <li><strong>Nama Hunian:</strong> {{ $riwayat->kost->nama }}</li>
            <li><strong>Tanggal Pembayaran:</strong> {{ $riwayat->created_at->format('d-m-Y H:i') }}</li>
        </ul>

        <p style="font-size: 16px; line-height: 1.6;">
            Silakan login ke dashboard untuk melihat detailnya.
        </p>

    </div>
</body>

</html>