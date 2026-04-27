@extends('layouts.app')

@section('content')
<div class="page-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transaksi</a></li>
            <li class="breadcrumb-item active">{{ $title_page }}</li>
        </ol>
    </nav>
</div>

<div class="container-fluid py-4">
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-primary font-weight-bold">Data Utama Transaksi</h5>
                    <div>
                        <a href="{{ route('transactions.print', $transaction->id) }}" class="btn btn-secondary btn-sm mr-2" target="_blank">
                            <i class="fas fa-print mr-1"></i> Cetak Bukti
                        </a>
                        <a href="{{ route('transactions.index') }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="section-container mb-5">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small text-uppercase font-weight-bold">Nomor Invoice</label>
                                <input type="text" class="form-control bg-light border-0 font-weight-bold" value="{{ $transaction->invoice_number }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small text-uppercase font-weight-bold">Asuransi</label>
                                <input type="text" class="form-control bg-light border-0" value="{{ $transaction->insurance->name ?? $transaction->insurance_name }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted small text-uppercase font-weight-bold">Status</label>
                                <div>
                                    <span class="badge {{ $transaction->status == 'paid' ? 'bg-success' : 'bg-danger' }} px-3 py-2">
                                        {{ strtoupper($transaction->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary font-weight-bold">Detail Tindakan Medis</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 text-muted small text-uppercase" style="width: 30%">Tindakan</th>
                                    <th class="border-0 text-muted small text-uppercase">Harga</th>
                                    <th class="border-0 text-muted small text-uppercase" style="width: 10%">Qty</th>
                                    <th class="border-0 text-muted small text-uppercase">Potongan/Item</th>
                                    <th class="border-0 text-muted small text-uppercase">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->details as $detail)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold">{{ $detail->procedure_name }}</div>
                                        <div class="small text-muted">Berlaku: {{ $detail->price_start_date }} s/d {{ $detail->price_end_date }}</div>
                                    </td>
                                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>Rp {{ number_format($detail->discount_per_item, 0, ',', '.') }}</td>
                                    <td class="font-weight-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="row justify-content-end">
                        <div class="col-md-5">
                            <table class="table table-hover border-0 bg-light-soft">
                                <tbody>
                                    <tr>
                                        <td class="text-right py-3 border-0">Total Sebelum Diskon Voucher</td>
                                        <td class="py-3 border-0 text-right">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="text-success">
                                        <td class="text-right py-3 border-0">Diskon Voucher</td>
                                        <td class="py-3 border-0 text-right">- Rp {{ number_format($transaction->total_discount, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr class="bg-primary text-white">
                                        <td class="text-right py-3 border-0 font-weight-bold">GRAND TOTAL</td>
                                        <td class="py-3 border-0 text-right font-weight-bold" style="font-size: 1.2rem;">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
