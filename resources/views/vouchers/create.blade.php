
@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Tambah {{ $title_page }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('vouchers.index') }}">Voucher</a></li>
                <li class="breadcrumb-item active">{{ $title_page }}</li>
            </ol>
        </nav>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('vouchers.store') }}" method="post">
                @csrf
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="name">Nama Voucher <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Contoh: Voucher Januari" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="code">Kode Voucher <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" placeholder="Contoh: V001" value="{{ old('code', $code) }}" required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="insurance_id">Pilih Asuransi <span class="text-danger">*</span></label>

                            <select name="insurance_id" id="select2" class="form-control form-select select2" required>
                                @foreach ($insurances as $insurance)
                                    <option value="{{ $insurance['id'] }}">{{ $insurance['name'] }}</option>
                                @endforeach
                            </select>
                            @error('insurance_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="type">Tipe Diskon <span class="text-danger">*</span></label>

                            <select name="type" class="form-control form-select" required>
                                <option value="percentage">Persentase</option>
                                <option value="fixed">Nominal</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="value">Nilai Voucher <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('value') is-invalid @enderror" id="value" name="value" placeholder="Contoh: 15000 atau 10" value="{{ old('value') }}" required>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="max_discount">Maksimal Diskon </label>
                            <input type="text" class="form-control @error('max_discount') is-invalid @enderror" id="max_discount" name="max_discount" placeholder="Contoh: 15000" value="{{ old('max_discount') }}">
                            @error('max_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="start_date">Tanggal Mulai Berlaku <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="end_date">Tanggal Akhir Berlaku <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('vouchers.index') }}" class="btn btn-light" type="button">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('stylesheet')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#insurance_id').select2({
                placeholder: 'Pilih Asuransi',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush