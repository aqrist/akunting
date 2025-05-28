<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Nota Lunas - {{ $project->nama_project }}</title>
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
            text-align: center;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
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

        .stamp {
            color: #28a745;
            border: 3px solid #28a745;
            padding: 10px;
            border-radius: 10px;
            font-weight: bold;
            text-align: center;
            transform: rotate(-15deg);
            width: 150px;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>NOTA LUNAS</h2>
            <p>Nomor: {{ $notaNumber }}</p>
            <p>Tanggal: {{ date('d/m/Y') }}</p>
        </div>

        <div class="stamp">
            LUNAS
        </div>

        <div class="client-info">
            <p>Telah diterima pembayaran dari:<br>
                <strong>{{ $project->client }}</strong>
            </p>
        </div>

        <div class="project-info">
            <h3>Detail Project</h3>
            <p>Nama Project: {{ $project->nama_project }}<br>
                Tanggal Mulai: {{ \Carbon\Carbon::parse($project->tanggal_mulai)->format('d/m/Y') }}<br>
                Tanggal Selesai: {{ \Carbon\Carbon::parse($lastPayment->tanggal)->format('d/m/Y') }}</p>
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
                        <strong>Total Nilai Project</strong>
                        @if (!empty($formattedDescription))
                            <ul>
                                @foreach ($formattedDescription as $section)
                                    <li>
                                        {{ $section['title'] }}
                                        @if (!empty($section['items']))
                                            <ul>
                                                @foreach ($section['items'] as $item)
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
        </table>

        <div class="payment-history">
            <h3>Riwayat Pembayaran</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($payment->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $payment->keterangan }}</td>
                            <td class="text-end">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total Pembayaran</th>
                        <th class="text-end">Rp {{ number_format($existingPayments, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer">
            <p>Dengan ini dinyatakan bahwa project telah LUNAS dibayar.</p>
            <br><br>
            <div style="float: right; text-align: center;">
                <p>{{ date('d/m/Y') }}</p>
                <br><br><br>
                <p>[Nama Perusahaan]</p>
            </div>
        </div>
    </div>
</body>

</html>
