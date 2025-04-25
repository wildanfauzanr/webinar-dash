<!DOCTYPE html>
<html>
<head>
    <title>Webinar Summary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 20px;
        }
        .statistics {
            margin: 20px 0;
            padding: 10px;
            background-color: #f5f5f5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Webinar Summary Report</h1>
        <p>Generated on {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i:s') }} WIB</p>
    </div>

    <div class="section">
        <h2>{{ $webinar->title }}</h2>
        <p><strong>Tanggal:</strong> {{ $webinar->date }}</p>
        <p><strong>Waktu:</strong> {{ $webinar->time }}</p>
    </div>

    <div class="section">
        <h3>Deskripsi</h3>
        <p>{{ $webinar->description }}</p>
    </div>

    <div class="statistics">
        <h3>Statistik</h3>
        <p><strong>Total Peserta:</strong> {{ $totalParticipants }} orang</p>
        <p><strong>Harga per Peserta:</strong> Rp {{ number_format($webinar->price, 0, ',', '.') }}</p>
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format( $totalParticipants*$webinar->price, 0, ',', '.') }}</p>
    </div>

    <div class="section">
        <h3>Daftar Peserta</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($webinar->applicants as $index => $participant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $participant->name }}</td>
                    <td>{{ $participant->email }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html> 