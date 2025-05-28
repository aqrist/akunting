@extends('layouts.app')

@section('title', 'Invoice Project - Keuangan Software House')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="mb-3">From:</h6>
                        <div>
                            <strong>PT. Guna Aplikasi Nusantara</strong>
                        </div>
                        <div>Jl. Randu 0102 Slawi Tegal</div>
                    </div>

                    <div class="col-sm-6">
                        <h6 class="mb-3">To:</h6>
                        <div>
                            <strong>{{ $project->client }}</strong>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <h6>Invoice Number:</h6>
                        <div>{{ $invoiceNumber }}</div>
                    </div>
                    <div class="col-sm-6">
                        <h6>Project Details:</h6>
                        <div>{{ $project->nama_project }}</div>
                        <div>Start Date: {{ \Carbon\Carbon::parse($project->tanggal_mulai)->format('d/m/Y') }}</div>
                        <div>Deadline: {{ \Carbon\Carbon::parse($project->deadline)->format('d/m/Y') }}</div>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($formattedDescription as $section)
                                <tr>
                                    <td>
                                        <strong>{{ $section['title'] }}</strong>
                                        @if (!empty($section['items']))
                                            <ul class="mb-0">
                                                @foreach ($section['items'] as $item)
                                                    <li>{{ $item }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if ($loop->first)
                                            Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total Project Value</th>
                                <th class="text-end">Rp {{ number_format($totalAmount, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th>Total Payments</th>
                                <th class="text-end">Rp {{ number_format($existingPayments, 0, ',', '.') }}</th>
                            </tr>
                            <tr class="table-primary">
                                <th>Remaining Balance</th>
                                <th class="text-end">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if ($payments->isNotEmpty())
                    <div class="mt-4">
                        <h6>Payment History:</h6>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($payment->tanggal)->format('d/m/Y') }}</td>
                                        <td>Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                                        <td>{{ $payment->keterangan }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="mt-4 d">
                    <p><strong>Notes:</strong></p>
                    <p>1. Please make payment to our bank account:</p>
                    <p>Bank Name: BCA<br>
                        Account Number: 3620500444<br>
                        Account Name: AQRIS TEGUH SATRIA PRADANA</p>
                    <p class="d-none">2. Please include invoice number in payment reference</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {

            .navbar,
            .sidebar,
            .footer {
                display: none !important;
            }

            .card {
                border: none !important;
            }

            .container {
                width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
        }
    </style>
@endpush
