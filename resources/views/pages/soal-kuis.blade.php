@extends('layouts.app')

@section('title', 'Add Materi')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('library/codemirror/theme/duotone-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <style>
        #fixed-timer {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #ffffff;
            z-index: 1000;
            padding: 10px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        body {
            padding-top: 60px;
            /* Sesuaikan dengan tinggi elemen timer */
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <!-- Modal untuk alert soal yang belum dijawab -->
        <div class="modal fade" id="unansweredModal" tabindex="-1" aria-labelledby="unansweredModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="unansweredModalLabel">Soal Belum Terjawab</h5>
                        <button type="button" class="btn-close" id="unansweredModalOkButton" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Anda belum mengisi jawaban untuk soal nomor berikut:
                        <span id="unansweredList" class="font-weight-bold text-danger"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="unansweredModalOkButton"
                            data-bs-dismiss="modal">OK</button>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal untuk Input Kode Quiz -->
        <div class="modal fade" id="codeModal" tabindex="-1" aria-labelledby="codeModalLabel" aria-hidden="true"
            data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="codeModalLabel">Masukkan Kode Quiz</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="quizCode" placeholder="Masukkan kode quiz">
                            <div class="alert alert-danger mt-2" id="codeError" style="display: none;">
                                Kode quiz tidak valid. Silakan coba lagi.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="verifyCode" class="btn btn-primary">Verifikasi</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Bootstrap untuk Fullscreen -->
        <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-labelledby="fullscreenModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fullscreenModalLabel">Mulai Ujian</h5>
                    </div>
                    <div class="modal-body">
                        <p>Untuk memulai ujian, halaman akan masuk ke mode fullscreen. Klik tombol "Mulai" untuk memulai
                            ujian.</p>
                    </div>
                    <div class="modal-footer">
                        <button id="startFullscreen" data-toggle="sidebar" class="btn btn-primary">Mulai</button>
                    </div>
                </div>
            </div>
        </div>

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
                            <div class="card-header d-flex justify-content-center w-100" id="fixed-timer">
                                <h3 class="text-danger font-weight-bold" id="timer" style="display: none;">
                                    {{ gmdate('H:i:s', $quiz->timer * 60) }}
                                </h3>
                            </div>

                            <form id="quizForm" class="form" action="{{ route('student.quizzes.submit', $quiz->id) }}"
                                method="post" enctype="multipart/form-data" onsubmit="return validateAnswers()">
                                @csrf
                                <?php $no = 1; ?>
                                <div class="card-body" id="quiz-content" style="display: none;">
                                    @foreach ($quiz->questions as $index => $question)
                                        <div class="form-group question-group" data-question-number="{{ $index + 1 }}">
                                            <h6 class="form-label text-dark mb-4 d-flex">
                                                <div>
                                                    <span class="mt-1 mr-2"> {{ $no }}. </span>
                                                </div>
                                                <div>
                                                    {!! nl2br(htmlspecialchars_decode($question->question)) !!}
                                                </div>
                                            </h6>
                                            <div class="row w-100">
                                                <input type="hidden" name="question_{{ $question->id }}" value="">
                                                <label class="col-12 w-100">
                                                    <input type="radio" name="question_{{ $question->id }}"
                                                        value="A" class="selectgroup-input">
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
                                            <button class="btn btn-primary" type="submit">Kirim</button>
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
            const codeModal = new bootstrap.Modal(document.getElementById('codeModal'), {
                backdrop: 'static',
                keyboard: false
            });

            const fullscreenModal = new bootstrap.Modal(document.getElementById('fullscreenModal'), {
                backdrop: 'static',
                keyboard: false
            });

            const unansweredModal = new bootstrap.Modal(document.getElementById('unansweredModal'), {
                backdrop: 'static',
                keyboard: false
            });

            // Show code modal first
            codeModal.show();
            const startButton = document.getElementById('startFullscreen');
            const quizForm = document.getElementById('quizForm');

            // Add event listener to the OK button inside unanswered modal
            document.getElementById('unansweredModalOkButton').addEventListener('click', function() {
                unansweredModal.hide(); // Hide the modal
            });

            // Get quiz code from backend
            const correctCode = '{{ $quiz->kode }}';

            // Function to verify quiz code
            function verifyQuizCode() {
                const inputCode = document.getElementById('quizCode').value.trim();
                const errorElement = document.getElementById('codeError');

                if (!inputCode) {
                    errorElement.textContent = 'Kode quiz tidak boleh kosong';
                    errorElement.style.display = 'block';
                    return;
                }

                if (inputCode === correctCode) {
                    // Hide code modal and show fullscreen modal
                    codeModal.hide();
                    fullscreenModal.show();
                    errorElement.style.display = 'none';
                } else {
                    // Show error message
                    errorElement.textContent = 'Kode quiz tidak valid. Silakan coba lagi.';
                    errorElement.style.display = 'block';
                    document.getElementById('quizCode').value = ''; // Clear input
                }
            }

            // Handle verify button click
            document.getElementById('verifyCode').addEventListener('click', verifyQuizCode);

            // Handle Enter key press in input field
            document.getElementById('quizCode').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    verifyQuizCode();
                }
            });

            function goFullscreen() {
                const elem = document.documentElement;
                const sidebar = document.getElementById('sidebar-wrapper');

                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }

                // Hide sidebar
                if (sidebar) {
                    console.log("Hiding sidebar");
                    sidebar.style.display = 'none';
                } else {
                    console.error("Sidebar not found");
                }
            }

            function handleFullscreenExit() {
                const sidebar = document.getElementById('sidebar-wrapper');
                if (sidebar) {
                    console.log("Showing sidebar");
                    sidebar.style.display = 'block';
                }
                if (
                    !document.fullscreenElement &&
                    !document.webkitFullscreenElement &&
                    !document.mozFullScreenElement &&
                    !document.msFullscreenElement
                ) {
                    alert('Anda keluar dari fullscreen! Ujian akan diakhiri.');
                    quizForm.submit();
                }
            }

            startButton.addEventListener('click', function() {
                goFullscreen();
                fullscreenModal.hide();
                startTimer(); // Start the timer and show quiz content
            });

            // Timer functionality
            let timerElement = document.getElementById('timer');
            let timeLeft = {{ $quiz->timer }} * 60;
            let timerInterval;

            function formatTime(seconds) {
                let hrs = Math.floor(seconds / 3600);
                let mins = Math.floor((seconds % 3600) / 60);
                let secs = seconds % 60;
                return `${hrs.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }

            function startTimer() {
                // Show timer and quiz content
                timerElement.style.display = 'block';
                document.getElementById('quiz-content').style.display = 'block';

                timerInterval = setInterval(function() {
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        quizForm.submit();
                    } else {
                        timerElement.textContent = formatTime(timeLeft);
                        timeLeft--;
                    }
                }, 1000);
            }

            // Validate unanswered questions
            function validateAnswers() {
                const unansweredQuestions = [];
                const questionGroups = document.querySelectorAll('.question-group');

                questionGroups.forEach(group => {
                    const questionNumber = group.getAttribute('data-question-number');
                    const inputs = group.querySelectorAll('input[type="radio"]');
                    let isAnswered = false;

                    inputs.forEach(input => {
                        if (input.checked) {
                            isAnswered = true;
                        }
                    });

                    if (!isAnswered) {
                        unansweredQuestions.push(questionNumber);
                    }
                });

                if (unansweredQuestions.length > 0) {
                    // Update modal content with unanswered questions
                    const unansweredList = document.getElementById('unansweredList');
                    unansweredList.textContent = unansweredQuestions.join(', ');

                    // Show modal
                    unansweredModal.show();

                    return false; // Prevent form submission
                }

                return true; // Allow form submission if all questions are answered
            }

            // Attach validation to form submit
            quizForm.addEventListener('submit', function(event) {
                if (!validateAnswers()) {
                    event.preventDefault(); // Stop form submission
                }
            });

            // Listen for fullscreen exit
            document.addEventListener('fullscreenchange', handleFullscreenExit);
            document.addEventListener('webkitfullscreenchange', handleFullscreenExit);
            document.addEventListener('mozfullscreenchange', handleFullscreenExit);
            document.addEventListener('msfullscreenchange', handleFullscreenExit);
        });
    </script>
@endsection

@push('scripts')
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('library/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script> <!-- Include custom.js here -->
@endpush
