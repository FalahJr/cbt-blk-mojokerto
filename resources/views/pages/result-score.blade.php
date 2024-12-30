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

                <h2 class="section-title">All Quiz</h2>
                <div class="row">

                    @foreach ($pelatihan as $list)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <article class="article article-style-b">
                                <div class="article-header">
                                    <div class="article-image" data-background="{{ asset('img/news/img15.jpg') }}">
                                    </div>
                                </div>
                                <div class="article-details">
                                    <div class="article-title">
                                        <h2 class="text-capitalize"><a href="#">{{ $list->nama }}</a></h2>
                                    </div>
                                    {{-- <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. </p> --}}
                                    <div class="article-cta">


                                        <a href="{{ route('admin.quizzes.showAllResultByAdmin', ['pelatihan_id' => $list->id]) }}"
                                            class="btn btn-info w-100 mt-5 d-flex justify-content-around  align-items-center ">View
                                            Score
                                            {{-- <i class="fas fa-chevron-right "></i> --}}
                                        </a>


                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach


                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
