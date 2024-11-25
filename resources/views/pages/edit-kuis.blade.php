@extends('layouts.app')

@section('title', 'Edit Quiz')

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
                <h1>Edit Quiz</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Quiz</a></div>
                    <div class="breadcrumb-item">Edit Quiz</div>
                </div>
            </div>

            <div class="section-body">


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Edit Quiz</h4>
                            </div>
                            <form class="form" action="/admin/quizzes/update/{{ $quiz->id }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="card-body">
                                    <div class="form-group ">
                                        <label class="">Title</label>
                                        <div class=" ">
                                            <input type="text" class="form-control" name="title"
                                                value="{{ $quiz->title }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Pilih Periode</label>
                                        <select class="form-control select2" name="periode_id">
                                            <option value="" hidden>Pilih Periode</option>
                                            @foreach ($periode as $list)
                                                <option value="{{ $list->id }}"
                                                    {{ $list->id == $quiz->periode_id ? 'selected' : '' }}>
                                                    {{ $list->nama }}</option>
                                            @endforeach
                                            {{-- <option>Option 2</option>
                                            <option>Option 3</option> --}}
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Timer</label>
                                        <div class=" ">
                                            <input type="number" class="form-control" name="timer"
                                                value="{{ $quiz->timer }}">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Tanggal Mulai</label>
                                        <div class=" ">
                                            <input type="date" class="form-control" name="tanggal_mulai"
                                                value="{{ $quiz->tanggal_mulai }}">
                                        </div>
                                    </div>
                                    <div class="form-group ">
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
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>
    <script src="{{ asset('library/codemirror/lib/codemirror.js') }}"></script>
    <script src="{{ asset('library/codemirror/mode/javascript/javascript.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
