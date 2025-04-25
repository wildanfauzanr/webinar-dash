<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bukti Pendaftaran Webinar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            color: #004080;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }
        .content {
            margin-bottom: 30px;
        }
        .webinar-info {
            margin-bottom: 20px;
        }
        .webinar-info p {
            margin: 5px 0;
        }
        .label {
            font-weight: bold;
            color: #004080;
        }
        .poster {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">BUKTI PENDAFTARAN WEBINAR</div>
        <div class="subtitle">Dash Webinar</div>
    </div>

    <div class="content">
        <div class="webinar-info">
            <p><span class="label">Nama Webinar:</span><br>{{ $webinar->title }}</p>
            <p><span class="label">Tanggal:</span><br>{{ \Carbon\Carbon::parse($webinar->date)->format('d F Y') }}</p>
            <p><span class="label">Waktu:</span><br>{{ \Carbon\Carbon::parse($webinar->time)->format('H:i') }} WIB</p>
            <p><span class="label">Deskripsi:</span><br>{{ $webinar->description }}</p>
            <p><span class="label">Nama Peserta:</span><br>{{ $user->name }}</p>
            <p><span class="label">Email Peserta:</span><br>{{ $user->email }}</p>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini adalah bukti pendaftaran resmi untuk webinar yang disebutkan di atas.</p>
        <p>© {{ date('Y') }} Dash Webinar. All rights reserved.</p>
    </div>
</body>
</html> 