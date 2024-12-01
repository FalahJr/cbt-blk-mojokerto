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
                            <div class="card-header d-flex justify-content-center w-100">
                                <h3 class="text-danger font-weight-bold" id="timer" style="display: none;">
                                    {{ gmdate('H:i:s', $quiz->timer * 60) }}
                                </h3>
                            </div>

                            <form id="quizForm" class="form" action="{{ route('student.quizzes.submit', $quiz->id) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <?php $no = 1; ?>
                                <div class="card-body" id="quiz-content" style="display: none;">
                                    @foreach ($quiz->questions as $question)
                                        <div class="form-group">
                                            {{-- <h6 class="form-label text-dark mb-4">{{ $no . '. ' . $question->question }}
                                            </h6> --}}
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


            // Show code modal first
            codeModal.show();
            const startButton = document.getElementById('startFullscreen');
            const quizForm = document.getElementById('quizForm');

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
                const sidebar = document.getElementById(
                    'sidebar-wrapper'); // Ensure this matches the ID of the sidebar

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

            // function handleFullscreenExit() {
            //     const sidebar = document.getElementById(
            //         'sidebar-wrapper'); // Ensure this matches the ID of the sidebar
            //     if (sidebar) {
            //         console.log("Showing sidebar");
            //         sidebar.style.display = 'block'; // Show sidebar again
            //     }
            // }

            function handleFullscreenExit() {
                const sidebar = document.getElementById(
                    'sidebar-wrapper'); // Ensure this matches the ID of the sidebar
                if (sidebar) {
                    console.log("Showing sidebar");
                    sidebar.style.display = 'block'; // Show sidebar again
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

            document.addEventListener('fullscreenchange', handleFullscreenExit);
            document.addEventListener('webkitfullscreenchange', handleFullscreenExit);
            document.addEventListener('mozfullscreenchange', handleFullscreenExit);
            document.addEventListener('msfullscreenchange', handleFullscreenExit);

            quizForm.addEventListener('submit', function() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
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
