@extends('layouts.app')
@section('content')

<div class="page-header">
    <h1 class="page-title">Data Master {{ $title_page }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{ $title_page }}</li>
        </ol>
    </nav>
</div>

@include('components.alert')

<div class="card">
    <div class="card-body">
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-striped dataTable" id="customDataTable" width="100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Aksi</th>
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
                url: '{{ route("procedures.data") }}',
                type: 'GET'
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
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