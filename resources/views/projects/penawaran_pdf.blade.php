<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Project Proposal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            line-height: 1.6;
            color: #333;
        }

        .header {
            margin-bottom: 30px;
        }

        .recipient {
            margin-bottom: 30px;
        }

        .project-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f5f5f5;
        }

        .total-row {
            font-weight: bold;
        }

        .notes {
            margin: 30px 0;
        }

        .signature {
            margin-top: 50px;
        }

        ul {
            list-style-type: disc;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="project-title">{{ strtoupper($project->nama_project) }}</div>
        <p>Number: {{ $penawaranNumber }}</p>
    </div>

    <div class="recipient">
        <p>To:</p>
        <p><strong>{{ $project->client }}</strong></p>
        <p>Dear Sir/Madam,</p>
        <p>We are pleased to submit our proposal for {{ $project->nama_project }}.</p>
    </div>

    <div class="section">
        <div class="section-title">Project Overview</div>
        @if (!empty($formattedDescription))
            @foreach ($formattedDescription as $section)
                <h4>{{ $section['title'] }}</h4>
                @if (!empty($section['items']))
                    <ul>
                        @foreach ($section['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                @endif
            @endforeach
        @else
            <p>{{ $project->keterangan ?: 'Project details will be provided here.' }}</p>
        @endif
    </div>

    <div class="section">
        <div class="section-title">Components and Cost Estimate</div>
        <table>
            <thead>
                <tr>
                    <th>Component</th>
                    <th style="text-align: right;">Cost (IDR)</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($formattedDescription))
                    @foreach ($formattedDescription as $section)
                        <tr>
                            <td>{{ $section['title'] }}</td>
                            <td style="text-align: right;">
                                {{ number_format($totalAmount / count($formattedDescription), 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Total Project Cost</td>
                        <td style="text-align: right;">{{ number_format($totalAmount, 0, ',', '.') }}</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td>Total Cost</td>
                    <td style="text-align: right;">{{ number_format($totalAmount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section notes">
        <div class="section-title">Additional Notes</div>
        <ul>
            <li>Development timeline will be discussed upon agreement</li>
            <li>This proposal is valid for 14 days from the date of issuance</li>
            <li>Payment terms and conditions will be specified in the contract</li>
        </ul>
    </div>

    <p>Please feel free to reach out if you require any adjustments to better suit your requirements.</p>

    <div class="signature">
        <p>Sincerely,</p>
        <p>PT Guna Aplikasi Nusantara</p>
        <br><br>
        <p>_______________________</p>
        <p>Aqris Teguh Satria Pradana</p>
    </div>
</body>

</html>
