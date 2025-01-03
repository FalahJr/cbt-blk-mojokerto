@extends('layouts.app')

@section('title', 'Management Soal')

@push('style')
    <!-- CSS Libraries -->
@endpush
<?php
use Illuminate\Support\Str;

?>

@section('main')
    <div class="main-content">
        <div class="modal " id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('questions.import', $quiz->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import Soal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="file">Pilih File Excel
                                </label> <br>
                                <a href="{{ asset('file_upload/template/template-import-soal.xlsx') }}" target="_blank"
                                    class=""> Download
                                    Template
                                    Excel</a><br>
                                <input type="file" class="form-control" id="file" name="file" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <section class="section">

            <div class="section-header">
                <h1 class="text-capitalize">{{ $quiz->title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Manajemen Soal</a></div>

                </div>
            </div>

            <div class="section-body">


                <div class="row">

                    <div class="col-12 ">
                        <div class="d-flex">
                            <a href="{{ route('questions.create', $quiz->id) }}" class="btn btn-success  mr-2 w-100">+
                                Tambah
                                Soal</a>
                            <a href="#" class="btn btn-primary w-100" data-toggle="modal"
                                data-target="#importModal">Import
                                Soal</a>
                        </div>
                        <!-- Modal -->


                        <div class="card mt-4">


                            <div class="card-body p-0">
                                <div class="table-responsive">

                                    <table class="table-striped table-md table">
                                        <tr>
                                            <th>#</th>
                                            <th>Daftar Soal</th>
                                            {{-- <th>Deskripsi</th>
                                            <th>Created By</th> --}}
                                            <th>Action</th>
                                        </tr>
                                        <?php $no = 1; ?>

                                        @foreach ($quiz->questions as $question)
                                            <tr>
                                                <td>{{ $no }}</td>

                                                <td>
                                                    <p><b>Soal : </b></p>
                                                    {!! nl2br(htmlspecialchars_decode($question->question)) !!}
                                                    <p><b>Pilihan Jawaban :</b></p>
                                                    <ul class="">
                                                        <li class="">A. {{ $question->option_a }}</li>
                                                        <li>B. {{ $question->option_b }}</li>
                                                        <li>C. {{ $question->option_c }}</li>
                                                        <li>D. {{ $question->option_d }}</li>
                                                        <li>E. {{ $question->option_e }}</li>
                                                    </ul>

                                                    <p><b>
                                                            Jawaban : {{ $question->correct_answer }}
                                                        </b></p>

                                                </td>
                                                <td> <a href="{{ route('questions.edit', [$quiz->id, $question->id]) }}"
                                                        class="btn btn-secondary">Edit</a>
                                                    <form
                                                        action="{{ route('questions.destroy', [$quiz->id, $question->id]) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </td>
                                                {{-- <td>{{ $no }}</td>
                                                <td>{{ $list->title }}</td>


                                                <td>
                                                    <div class="d-flex">
                                                        <a href="{{ route('quizzes.show', $quiz->id) }}"
                                                            class="btn btn-info mr-4">Detail</a>
                                                        <a href="materi/{{ $list->id }}/edit"
                                                            class="btn btn-success mr-4">Edit</a>
                                                        <form class="" method="POST"
                                                            action="/teacher/materi/{{ $list->id }}">
                                                            {{ csrf_field() }}
                                                            @method('DELETE')
                                                            <button class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </td> --}}
                                            </tr>
                                            <?php $no++; ?>
                                        @endforeach


                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
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
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/components-table.js') }}"></script>
@endpush
