@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Tambah {{ $title_page }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategori</a></li>
                <li class="breadcrumb-item active">{{ $title_page }}</li>
            </ol>
        </nav>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="post">
                @csrf
                <div class="form-section">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="name">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama kategori" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button class="btn btn-primary me-md-2" type="submit">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                        <a href="{{ route('categories.index') }}" class="btn btn-light" type="button">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection