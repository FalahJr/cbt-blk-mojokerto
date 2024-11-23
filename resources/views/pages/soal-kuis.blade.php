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
                <h1>Quiz</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Materi</a></div>
                    <div class="breadcrumb-item">Quiz</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- Timer display -->
                            <div class="card-header d-flex justify-content-center w-100">
                                <h3 class="text-danger font-weight-bold" id="timer">
                                    {{ gmdate('H:i:s', $quiz->timer * 60) }}
                                </h3>
                            </div>

                            <form id="quizForm" class="form" action="{{ route('student.quizzes.submit', $quiz->id) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <?php $no = 1; ?>
                                <div class="card-body">
                                    @foreach ($quiz->questions as $question)
                                        <div class="form-group">
                                            <h6 class="form-label text-dark mb-4">{{ $no . '. ' . $question->question }}
                                            </h6>
                                            <div class="row w-100">
                                                <!-- Hidden input to ensure a value is always sent for each question -->
                                                <input type="hidden" name="question_{{ $question->id }}" value="">
                                                <label class="col-12 w-100">
                                                    <input type="radio" name="question_{{ $question->id }}" value="A"
                                                        class="selectgroup-input">
                                                    <span class="selectgroup-button">A. {{ $question->option_a }}</span>
                                                </label>
                                                <label class="col-12 w-100">
                                                    <input type="radio" name="question_{{ $question->id }}"
                                                        value="B" class="selectgroup-input">
                                                    <span class="selectgroup-button">B. {{ $question->option_b }}</span>
                                                </label>
                                                <label class="col-12 w-100">
                                                    <input type="radio" name="question_{{ $question->id }}"
                                                        value="C" class="selectgroup-input">
                                                    <span class="selectgroup-button">C. {{ $question->option_c }}</span>
                                                </label>
                                                <label class="col-12 w-100">
                                                    <input type="radio" name="question_{{ $question->id }}"
                                                        value="D" class="selectgroup-input">
                                                    <span class="selectgroup-button">D. {{ $question->option_d }}</span>
                                                </label>
                                                <label class="col-12 w-100">
                                                    <input type="radio" name="question_{{ $question->id }}"
                                                        value="E" class="selectgroup-input">
                                                    <span class="selectgroup-button">E. {{ $question->option_e }}</span>
                                                </label>
                                            </div>
                                        </div>
                                        <?php $no++; ?>
                                    @endforeach
                                    <div class="form-group">
                                        <div class="">
                                            <button class="btn btn-primary" type="submit">Publish</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let timerElement = document.getElementById('timer');
            let timeLeft = {{ $quiz->timer }} * 60; // Timer in minutes converted to seconds

            function formatTime(seconds) {
                let hrs = Math.floor(seconds / 3600);
                let mins = Math.floor((seconds % 3600) / 60);
                let secs = seconds % 60;
                return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }

            let timerInterval = setInterval(function() {
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    document.getElementById('quizForm').submit();
                } else {
                    timerElement.textContent = formatTime(timeLeft);
                    timeLeft--;
                }
            }, 1000);
        });
    </script>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('library/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
