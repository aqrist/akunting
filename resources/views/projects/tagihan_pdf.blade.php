<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tagihan Project - {{ $project->nama_project }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }
        .container {
            padding: 20px;
        }
        .header {
            margin-bottom: 30px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .text-end {
            text-align: right;
        }
        .footer {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>TAGIHAN</h2>
            <p>Nomor: {{ $tagihanNumber }}</p>
            <p>Tanggal: {{ date('d/m/Y') }}</p>
        </div>

        <div class="client-info">
            <p>Kepada Yth,<br>
            <strong>{{ $project->client }}</strong></p>
        </div>

        <div class="project-info">
            <h3>Detail Project</h3>
            <p>Nama Project: {{ $project->nama_project }}<br>
            Tanggal Mulai: {{ \Carbon\Carbon::parse($project->tanggal_mulai)->format('d/m/Y') }}<br>
            Deadline: {{ \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th class="text-end">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Nilai Project</strong>
                        @if(!empty($formattedDescription))
                            <ul>
                            @foreach($formattedDescription as $section)
                                <li>
                                    {{ $section['title'] }}
                                    @if(!empty($section['items']))
                                        <ul>
                                            @foreach($section['items'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </td>
                    <td class="text-end">Rp {{ number_format($totalAmount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total Pembayaran</th>
                    <th class="text-end">Rp {{ number_format($existingPayments, 0, ',', '.') }}</th>
                </tr>
                <tr>
                    <th>Sisa Pembayaran</th>
                    <th class="text-end">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>

        <div class="payment-info">
            <h3>Informasi Pembayaran</h3>
            <p>Mohon melakukan pembayaran ke rekening berikut:</p>
            <p>Bank: BCA<br>
            No. Rekening: 3620500444<br>
            Atas Nama: AQRIS TEGUH SATRIA PRADANA</p>
        </div>

        <div class="footer">
            <p>Hormat kami,</p>
            <br><br><br>
            <p>PT. Guna Aplikasi Nusantara</p>
        </div>
    </div>
</body>
</html>