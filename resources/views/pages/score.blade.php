@extends('layouts.app')

@section('title', 'Add Materi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('library/codemirror/theme/duotone-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Leaderboard</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Materi</a></div>
                    <div class="breadcrumb-item">Add Materi</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            @if (session('user')['role'] === 'Admin')

                                <div class="card-header">
                                    <h4>Filter Berdasarkan Jenis Pelatihan</h4>
                                </div>

                                <div class="card-body">
                                    <!-- Dropdown untuk admin -->
                                    <form action="{{ route('admin.quizzes.showAllResultByAdmin', $quizzes_id) }}"
                                        method="GET">
                                        <div class="form-group">
                                            <label for="pelatihan_id">Pilih Pelatihan</label>
                                            <select class="form-control" id="pelatihan_id" name="pelatihan_id" required>
                                                <option value="" disabled selected>-- Pilih Jenis Pelatihan --
                                                </option>
                                                @foreach ($pelatihan as $p)
                                                    <option value="{{ $p->id }}"
                                                        {{ request('pelatihan_id') == $p->id ? 'selected' : '' }}>
                                                        {{ $p->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary mr-2">Tampilkan</button>
                                            @if (request('pelatihan_id'))
                                                <a href="{{ route('quizzes.export', ['quizzes_id' => $quizzes_id, 'pelatihan_id' => request('pelatihan_id')]) }}"
                                                    class="btn btn-success">Export to Excel</a>
                                            @else
                                                <button type="submit" class="btn btn-secondary mr-2" disabled>Export to
                                                    Excel</button>
                                            @endif

                                        </div>
                                    </form>

                                </div>
                            @else
                                <!-- Data langsung ditampilkan untuk guru -->

                                <div class="card-header">

                                    <p class="text-info">
                                        Data ditampilkan berdasarkan pelatihan Anda:
                                        <strong>{{ $pelatihan->where('id', session('user')['pelatihan_id'])->first()->nama ?? 'Tidak Diketahui' }}</strong>
                                    </p>
                                </div>
                                <div class="card-body">
                                    <a href="{{ route('guru.quizzes.export', ['quizzes_id' => $quizzes_id, 'pelatihan_id' => request('pelatihan_id')]) }}"
                                        class="btn btn-success">Export to Excel</a>
                                </div>
                            @endif
                        </div>

                        @if ($listQuizAttempt != null)
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table-striped table-md table">
                                            <thead>
                                                <tr>
                                                    <th>Ranking</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Nilai</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($listQuizAttempt as $index => $list)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $list->nama_lengkap }}</td>
                                                        <td>{{ $list->score }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="3" class="text-center">Data tidak ditemukan</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info">Pilih Jenis Pelatihan Terlebih Dahulu.</div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('library/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
@endpush
