@extends('layouts.app')

@section('title', 'Quiz')

@push('style')
    <!-- CSS Libraries -->
@endpush

<?php
use App\Models\QuizAttempts;

?>

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Quiz</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Quiz</div>
                </div>
            </div>

            <div class="section-body">
                @if ($quizzes == null && $quiz_attempt == null)
                    <div class="row">
                        <div class="col-12 ">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Ujian Belum Tersedia</h4>
                                </div>
                                <div class="card-body">
                                    <div class="empty-state" data-height="400">

                                        <p class="lead">
                                            Silahkan tunggu pengumuman lebih lanjut dari panitia.
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @if (Session('user')['role'] != 'Murid')


                        <h2 class="section-title">All Quiz</h2>
                        <div class="row">

                            @foreach ($quizzes as $list)
                                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                    <article class="article article-style-b">
                                        <div class="article-header">
                                            <div class="article-image" data-background="{{ asset('img/news/img15.jpg') }}">
                                            </div>
                                        </div>
                                        <div class="article-details">
                                            <div class="article-title">
                                                <h2 class="text-capitalize"><a href="#">{{ $list->title }}</a></h2>
                                            </div>
                                            {{-- <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. </p> --}}
                                            <div class="article-cta">

                                                @if (Session('user')['role'] == 'Guru')
                                                    <a href="{{ route('teacher.quizzes.showAllResultByGuru', ['quiz_id' => $list->id]) }}"
                                                        class="btn btn-info w-100 mt-5 d-flex justify-content-around  align-items-center ">View
                                                        Score
                                                        {{-- <i class="fas fa-chevron-right "></i> --}}
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.quizzes.showAllResultByAdmin', ['quiz_id' => $list->id]) }}"
                                                        class="btn btn-info w-100 mt-5 d-flex justify-content-around  align-items-center ">View
                                                        Score
                                                        {{-- <i class="fas fa-chevron-right "></i> --}}
                                                    </a>
                                                @endif


                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach


                        </div>
                    @else
                        @if ($kelulusan !== null)

                            @if ($kelulusan->status === 'Pending' || $kelulusan->status === 'Lolos')

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
                                                <h4>Ujian Selesai</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="empty-state" data-height="400">
                                                    {{-- <div class="empty-state-icon bg-success ">
                                                <i class="fa-solid fa-award"></i>
                                            </div> --}}
                                                    {{-- <h2>Your Score : {{ $quizAttempt->score }}</h2> --}}
                                                    <h2>
                                                        Selamat anda telah menyelesaikan ujian
                                                    </h2>
                                                    <p class="lead">
                                                        Silahkan tunggu pengumuman lebih lanjut dari panitia.
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
                            @elseif ($kelulusan->status === 'Tidak Lolos')
                                @if ($quiz_attempt)
                                    @if ($quiz_attempt->quizzes_id === $quizzes->id)
                                        <div class="row">


                                            <div class="col-12 ">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4>Ujian Selesai</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="empty-state" data-height="400">
                                                            {{-- <div class="empty-state-icon bg-success ">
                                                        <i class="fa-solid fa-award"></i>
                                                    </div> --}}
                                                            {{-- <h2>Your Score : {{ $quizAttempt->score }}</h2> --}}
                                                            <h2>
                                                                Selamat anda telah menyelesaikan ujian
                                                            </h2>
                                                            <p class="lead">
                                                                Silahkan tunggu pengumuman lebih lanjut dari panitia.
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
                                    @endif
                                @else
                                    <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                                        <div class="section-header">
                                            <div class="d-flex flex-column">
                                                <h1>HALO {{ Session('user')['nama_lengkap'] }} !!!</h1>
                                                <p>Yuk kita belajar bersama</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">


                                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                            <article class="article article-style-b">
                                                <div class="article-header">
                                                    <div class="article-image"
                                                        data-background="{{ asset('img/news/img15.jpg') }}">
                                                    </div>
                                                </div>
                                                <div class="article-details">
                                                    <div class="article-title">
                                                        <h2 class="text-capitalize"><a
                                                                href="#">{{ $quizzes->title }}</a>
                                                        </h2>
                                                    </div>
                                                    {{-- <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. </p> --}}
                                                    <div class="article-cta">
                                                        @if (Session('user')['role'] == 'Murid')
                                                            @if (now()->toDateString() >= $quizzes->tanggal_mulai)
                                                                <a href="/student/quizzes/{{ $quizzes->id }}"
                                                                    class="btn btn-success w-100 mt-5">Mulai Ujian
                                                                    <i class="fas fa-chevron-right"></i></a>
                                                            @else
                                                                <button disabled class="btn btn-secondary w-100 mt-5"
                                                                    disabled>Mulai
                                                                    Ujian</button>
                                                            @endif
                                                        @else
                                                            <a href="{{ route('teacher.quizzes.showAllResultByGuru', ['quiz_id' => $quizzes->id]) }}"
                                                                class="btn btn-info w-100 mt-5 d-flex justify-content-around  align-items-center ">View
                                                                Score
                                                                {{-- <i class="fas fa-chevron-right "></i> --}}
                                                            </a>
                                                        @endif


                                                    </div>
                                                </div>
                                            </article>
                                        </div>

                                    </div>
                                @endif

                            @endif
                        @else
                            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                                <div class="section-header">
                                    <div class="d-flex flex-column">
                                        <h1>HALO {{ Session('user')['nama_lengkap'] }} !!!</h1>
                                        <p>Yuk kita belajar bersama</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                    <article class="article article-style-b">
                                        <div class="article-header">
                                            <div class="article-image" data-background="{{ asset('img/news/img15.jpg') }}">
                                            </div>
                                        </div>
                                        <div class="article-details">
                                            <div class="article-title">
                                                <h2 class="text-capitalize"><a href="#">{{ $quizzes->title }}</a>
                                                </h2>
                                            </div>
                                            {{-- <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. </p> --}}
                                            <div class="article-cta">
                                                @if (Session('user')['role'] == 'Murid')
                                                    @if (now()->toDateString() >= $quizzes->tanggal_mulai)
                                                        <a href="/student/quizzes/{{ $quizzes->id }}"
                                                            class="btn btn-success w-100 mt-5">Mulai Ujian
                                                            <i class="fas fa-chevron-right"></i></a>
                                                    @else
                                                        <button disabled class="btn btn-disable w-100 mt-5" disabled>Mulai
                                                            Ujian</button>
                                                    @endif
                                                @elseif (Session('user')['role'] == 'Guru')
                                                    <a href="{{ route('teacher.quizzes.showAllResultByGuru', ['quiz_id' => $quizzes->id]) }}"
                                                        class="btn btn-info w-100 mt-5 d-flex justify-content-around  align-items-center ">View
                                                        Score
                                                        {{-- <i class="fas fa-chevron-right "></i> --}}
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.quizzes.showAllResultByAdmin', ['quiz_id' => $quizzes->id]) }}"
                                                        class="btn btn-info w-100 mt-5 d-flex justify-content-around  align-items-center ">View
                                                        Score
                                                        {{-- <i class="fas fa-chevron-right "></i> --}}
                                                    </a>
                                                @endif


                                            </div>
                                        </div>
                                    </article>
                                </div>

                            </div>
                        @endif
                    @endif
                @endif

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
