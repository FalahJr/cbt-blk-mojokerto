@extends('layouts.app')

@section('title', 'Assignment')

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
                <h1>Assignment</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Assignment</div>
                </div>
            </div>

            <div class="section-body">

                <h2 class="section-title">All Assignment</h2>
                <div class="row">

                    @foreach ($data as $list)
                        <?php
                        // $cek = QuizAttempts::where('user_id', '=', Session('user')['id'])
                        //     ->where('quizzes_id', '=', $list->id)
                        //     ->first();
                        
                        // dd($cek);
                        ?>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <article class="article article-style-b">
                                <div class="article-header">
                                    <div class="article-image"
                                        data-background="{{ asset('img/assignment/' . $list->gambar) }}">
                                    </div>
                                </div>
                                <div class="article-details">
                                    <div class="article-title">
                                        <h2 class="text-capitalize"><a href="#">{{ $list->judul }}</a></h2>
                                        <p>Nama Materi : {{ $list->judul_materi }}</p>
                                    </div>
                                    {{-- <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. </p> --}}
                                    <div class="article-cta">
                                        {{-- @if (Session('user')['role'] == 'Murid')
                                            @if ($cek) --}}
                                        {{-- <a href="{{ route('student.quizzes.resultByUser', ['user_id' => Session('user')['id'], 'quiz_id' => $list->id]) }}"
                                            class="btn btn-info w-100 mt-5 d-flex justify-content-around  align-items-center ">View
                                            Score
                                        </a> --}}
                                        {{-- @else --}}
                                        @if (Session('user')['role'] == 'Murid')
                                            <a href="/student/assignment/submission/{{ $list->id }}"
                                                class="btn btn-success w-100 mt-5">View Detail
                                                <i class="fas fa-chevron-right"></i></a>
                                        @else
                                            <a href="/teacher/assignments/submission/{{ $list->id }}"
                                                class="btn btn-info w-100 mt-5">View Submissions
                                                <i class="fas fa-chevron-right"></i></a>
                                        @endif
                                        {{--  @endif
                                        @else
                                            <a href="{{ route('teacher.quizzes.showAllResultByGuru', ['quiz_id' => $list->id]) }}"
                                                class="btn btn-info w-100 mt-5 d-flex justify-content-around  align-items-center ">View
                                                Score
                                            </a>
                                        @endif --}}


                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach

                    {{-- <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article article-style-b">
                            <div class="article-header">
                                <div class="article-image" data-background="{{ asset('img/news/img07.jpg') }}">
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-title">
                                    <h2><a href="#">Excepteur sint occaecat cupidatat non proident</a></h2>
                                </div>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. </p>
                                <div class="article-cta">
                                    <a href="#">Read More <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article article-style-b">
                            <div class="article-header">
                                <div class="article-image" data-background="{{ asset('img/news/img02.jpg') }}">
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-title">
                                    <h2><a href="#">Excepteur sint occaecat cupidatat non proident</a></h2>
                                </div>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. </p>
                                <div class="article-cta">
                                    <a href="#">Read More <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </article>
                    </div> --}}
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
