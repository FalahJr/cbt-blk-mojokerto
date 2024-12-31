@extends('layouts.app')

@section('title', 'Setting Reset Data')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">

        <section class="section">

            <div class="section-header">
                <h1>Setting Reset Data</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Setting Reset Data</a></div>
                </div>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header text-white">
                    <h4>Pengaturan</h4>
                </div>
                <div class="card-body">
                    <p class="text-danger">
                        <strong>Perhatian:</strong> Tindakan ini akan menghapus semua data kecuali pengguna dengan peran
                        Admin dan Guru. Pastikan Anda yakin sebelum melanjutkan.
                    </p>
                    <form action="{{ route('settings.reset') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus semua data?')">
                            Reset Semua Data
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/components-table.js') }}"></script>
@endpush
