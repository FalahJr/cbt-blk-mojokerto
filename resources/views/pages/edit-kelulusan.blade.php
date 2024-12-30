@extends('layouts.app')

@section('title', 'Edit Kelulusan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Kelulusan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kelulusan</a></div>
                    <div class="breadcrumb-item">Edit</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('kelulusan.update', $kelulusan->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nama_lengkap">Nama Peserta</label>
                                        <input type="text" class="form-control" id="nama_lengkap"
                                            value="{{ $kelulusan->user->nama_lengkap }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="score">Nilai Quiz</label>
                                        <input type="text" class="form-control" id="score"
                                            value="{{ $kelulusan->quizAttempt->score ?? 'N/A' }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="nilai_wawancara">Nilai Wawancara</label>
                                        <input type="number" class="form-control" id="nilai_wawancara"
                                            name="nilai_wawancara" value="{{ $kelulusan->nilai_wawancara }}" disabled>
                                    </div>

                                    <div class="form-group">
                                        <label for="status">Status Kelulusan</label>
                                        <select name="status" id="status" class="form-control" required>
                                            <option value="Lolos" {{ $kelulusan->status == 'Lolos' ? 'selected' : '' }}>
                                                Lolos</option>
                                            <option value="Tidak Lolos"
                                                {{ $kelulusan->status == 'Tidak Lolos' ? 'selected' : '' }}>Tidak Lolos
                                            </option>
                                            <option value="Pending" {{ $kelulusan->status == 'Pending' ? 'selected' : '' }}>
                                                Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('kelulusan.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
@endpush
