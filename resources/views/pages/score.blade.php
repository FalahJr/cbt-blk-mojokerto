@extends('layouts.app')

@section('title', 'Hasil Tes')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Hasil Tes</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Hasil Tes</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pelatihan: {{ $pelatihan->nama }}</h4>
                            </div>
                            <a href="{{ route('quizzes.export', ['pelatihan_id' => $pelatihan->id, 'periode_id' => $periode_id]) }}"
                                class="btn btn-success mx-4 btn-sm">Export to Excel</a>

                            <div class="card-body">
                                <!-- Tabs untuk periode -->
                                <ul class="nav nav-tabs" id="periodeTabs" role="tablist">
                                    @foreach ($periodes as $periode)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $periode->id == $periode_id ? 'active' : '' }}"
                                                href="{{ route('admin.quizzes.showAllResultByAdmin', ['pelatihan_id' => $pelatihan->id, 'periode_id' => $periode->id]) }}">
                                                {{ $periode->nama }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                <!-- Tabel leaderboard -->
                                <div class="table-responsive mt-3">
                                    <table class="table-striped table-md table">
                                        <thead>
                                            <tr>
                                                <th>Ranking</th>
                                                <th>Nomor Peserta</th>
                                                <th>Nama Lengkap</th>
                                                <th>Nilai</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($listQuizAttempt as $index => $list)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $list->nomor_peserta }}</td>
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

                            {{-- <div class="card-footer text-right">
                                <a href="{{ route('quizzes.export', ['pelatihan_id' => $pelatihan->id, 'periode_id' => $periode_id]) }}"
                                    class="btn btn-success">Export to Excel</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
