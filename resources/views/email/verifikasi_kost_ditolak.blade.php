<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verifikasi Hunian</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 20px;">Halo {{ $user->name }},</h2>

        <p style="font-size: 16px; line-height: 1.6;">
            Kami mohon maaf, proses verifikasi untuk kost atau kontrakan Anda <strong>{{ $kost->nama }}</strong> telah <strong>ditolak</strong>.
        </p>

        <p style="font-size: 16px; line-height: 1.6;">
            Silakan periksa kembali kelengkapan dokumen dan informasi yang Anda unggah. Anda dapat melakukan pengajuan ulang verifikasi setelah melakukan perbaikan.
        </p>

        <p style="font-size: 16px; line-height: 1.6;">
            Terima kasih atas pengertian Anda.
        </p>
    </div>
</body>
</html>
