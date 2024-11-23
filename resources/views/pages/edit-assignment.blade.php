@extends('layouts.app')

@section('title', 'Edit Assignment')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/codemirror/lib/codemirror.css') }}">
    <link rel="stylesheet" href="{{ asset('library/codemirror/theme/duotone-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Assignment</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Assignment</a></div>
                    <div class="breadcrumb-item">Edit Assignment</div>
                </div>
            </div>

            <div class="section-body">


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Edit Assignment</h4>
                            </div>
                            <form class="form" action="/teacher/assignment/{{ Request::segment(3) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">

                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                                        <div class="col-sm-12 col-md-7">
                                            <select class="form-control selectric" name="materi_id">
                                                <option value="" disabled selected>Choose Material</option>

                                                @foreach ($materi as $list)
                                                    <option value="{{ $list->id }}"
                                                        {{ $list->id == $assignment->materi_id ? 'selected' : '' }}>
                                                        {{ $list->judul }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control" name="judul"
                                                value="{{ $assignment->judul }}">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="w-100" rows="6" name="deskripsi">
                                                {{ $assignment->deskripsi }}
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                                        <div class="col-sm-12 col-md-7">
                                            <div id="image-preview" class="image-preview"
                                                style="background-image: url('{{ asset('img/assignment/' . $assignment->gambar) }}') ; background-size: cover;
                                                background-position: center center;">
                                                <label for="image-upload" id="image-label">Choose Thumbnail</label>
                                                <input type="file" name="gambar" id="image-upload"
                                                    value="{{ asset('img/assignment/' . $assignment->gambar) }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">File</label>
                                        <div class="col-sm-12 col-md-7">
                                            <a href="{{ asset('file_upload/assignment/' . $assignment->file) }}"
                                                class="btn btn-primary btn-md mb-3" target="_blank">
                                                View File
                                            </a>
                                            <input type="file" class="form-control" name="file">

                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">

                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Start
                                            Date</label>
                                        <div class="col-sm-12 col-md-7">

                                            <input type="text" class="form-control datepicker" name="start_date"
                                                value="{{ $assignment->start_date }}">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">

                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">End
                                            Date</label>
                                        <div class="col-sm-12 col-md-7">

                                            <input type="text" class="form-control datepicker" name="end_date"
                                                value="{{ $assignment->end_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button class="btn btn-primary" type="submit">Publish</button>
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
    <script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>

    <script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-post-create.js') }}"></script>
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <!-- Page Specific JS File -->
@endpush
