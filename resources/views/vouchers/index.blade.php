@extends('layouts.app')
@section('content')

<div class="page-header">
    <h1 class="page-title">Data {{ $title_page }}</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">{{ $title_page }}</li>
        </ol>
    </nav>
</div>

@include('components.alert')

<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-2">
    <label>&nbsp;</label>
    <a href="{{ route('vouchers.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Data
    </a>
</div>

<div class="card">
    <div class="card-body">
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-striped dataTable" id="customDataTable" width="100%">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Nilai</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
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
                url: '{{ route("vouchers.data") }}',
                type: 'GET'
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'code', name: 'code' },
                { data: 'value', name: 'value' },
                { data: 'start_date', name: 'start_date' },
                { data: 'end_date', name: 'end_date' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
            }
        });
    });

    function deleteData(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('vouchers.destroy', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        "_method": "DELETE",
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire(
                                'Terhapus!',
                                response.message,
                                'success'
                            );
                            $('#customDataTable').DataTable().ajax.reload();
                        } else {
                            Swal.fire(
                                'Gagal!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus data.',
                            'error'
                        );
                    }
                });
            }
        })
    }
</script>
@endpush