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
                @if (Session('user')['role'] == 'Murid')
                    <h1>Hasil Quiz</h1>
                @else
                    <h1>Leaderboard</h1>
                @endif
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Materi</a></div>
                    <div class="breadcrumb-item">Add Materi</div>
                </div>
            </div>

            <div class="section-body">


                <div class="row">

                    @if (Session('user')['role'] == 'Murid')
                        <div class="col-12 ">
                            <div class="card">

                                <div class="card-body">
                                    <div class="empty-state" data-height="150">
                                        <div class="empty-state-icon bg-success ">
                                            <i class="fa-solid fa-award"></i>
                                            {{-- <i class="fas fa-question"></i> --}}
                                        </div>
                                        <h2>Your Score : {{ $quizAttempt->score }}</h2>


                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-12 ">
                        @if (Session('user')['role'] == 'Guru')
                            {{-- <div class="section-header">
                                <h1>Leaderboard</h1>

                            </div> --}}


                            <div class="card-body p-0">
                                <div class="table-responsive">

                                    <table class="table-striped table-md table">
                                        <tr>
                                            <th>Ranking</th>
                                            <th>Nama Lengkap</th>
                                            <th>Nilai</th>
                                            {{-- <th>Created By</th> --}}
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                        <?php $no = 1; ?>

                                        @foreach ($listQuizAttempt as $list)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $list->nama_lengkap }}</td>

                                                <td>
                                                    {{ $list->score }}
                                                </td>

                                            </tr>
                                            <?php $no++; ?>
                                        @endforeach


                                    </table>
                                </div>
                            </div>
                        @endif

                        {{-- <div class="card-footer text-right">
                            <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1"><i
                                                class="fas fa-chevron-left"></i></a>
                                    </li>
                                    <li class="page-item active"><a class="page-link" href="#">1 <span
                                                class="sr-only">(current)</span></a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">2</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                                    </li>
                                </ul>
                            </nav>
                        </div> --}}
                    </div>
                </div>
            </div>


    </div>
    </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('library/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
