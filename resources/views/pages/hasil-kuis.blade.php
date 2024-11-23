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
                <h1>Hasil Quiz</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Materi</a></div>
                    <div class="breadcrumb-item">Add Materi</div>
                </div>
            </div>

            <div class="section-body">


                <div class="row">
                    {{-- <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Hasil Kuis: {{ $quiz->title }}</h4>
                                <h4>Skor Anda: {{ $quizAttempt->score }}</h4>
                            </div>

                        </div>
                    </div> --}}

                    <div class="col-12 ">
                        <div class="card">
                            <div class="card-header">
                                <h4>Result Quiz</h4>
                            </div>
                            <div class="card-body">
                                <div class="empty-state" data-height="400">
                                    <div class="empty-state-icon bg-success ">
                                        <i class="fa-solid fa-award"></i>
                                        {{-- <i class="fas fa-question"></i> --}}
                                    </div>
                                    <h2>Your Score : {{ $quizAttempt->score }}</h2>
                                    <p class="lead">
                                        Selamat anda telah menyelesaikan ujian : <b class="text-capitalize">
                                            {{ $quiz->title }} </b>.
                                        {{-- Sekarang anda bisa melihat peringkat skor anda melalui tombol dibawah ini --}}
                                    </p>
                                    {{-- <a href="{{ route('student.quizzes.resultByUser', ['user_id' => Session('user')['id'], 'quiz_id' => $quiz->id]) }}"
                                        class="btn btn-primary mt-4">Leaderboard</a> --}}
                                    {{-- <a href="#" class="bb mt-4">Need Help?</a> --}}
                                </div>
                            </div>
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
