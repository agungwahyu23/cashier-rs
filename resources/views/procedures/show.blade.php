{{-- @dd($procedure) --}}
@extends('layouts.app')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit {{ $title_page }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('procedures.index') }}">Tindakan Medis</a></li>
                <li class="breadcrumb-item active">{{ $title_page }}</li>
            </ol>
        </nav>
    </div>

    <a href="{{ route('procedures.index') }}" class="btn btn-primary mb-3"><i class="fa-solid fa-arrow-left"></i> Kembali</a>

    <div class="card mb-4">
        <div class="card-body">
            <div class="form-section">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="name">Nama Tindakan Medis</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Teks" value="{{ $procedure['name'] ?? '-' }}" readonly>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            Daftar Harga
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped dataTable" id="customDataTable" width="100%">
                    <thead>
                        <tr>
                            <th>Harga</th>
                            <th>Tgl Mulai Berlaku</th>
                            <th>Tgl Akhir Berlaku</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script>
    $(document).ready(function() {
        // Initialize DataTable dengan server-side processing
        var table = $('#customDataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("price-procedure.data", $procedure["id"]) }}',
                type: 'GET'
            },
            columns: [
                { data: 'unit_price', name: 'unit_price' },
                { data: 'start_date.formatted', name: 'start_date' },
                { data: 'end_date.formatted', name: 'end_date' }
            ],
            columnDefs: [
                {
                    targets: 0, // Kolom unit_price
                    render: function(data, type, row) {
                        if (type === 'display') {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                        }
                        return data;
                    }
                }
            ],
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            }
        });
    });
</script>
@endpush