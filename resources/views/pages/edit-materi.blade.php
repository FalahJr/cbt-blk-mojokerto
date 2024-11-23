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
                <h1>Edit Materi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Materi</a></div>
                    <div class="breadcrumb-item">Edit Materi</div>
                </div>
            </div>

            <div class="section-body">


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Edit Materi</h4>
                            </div>
                            <form class="form" action="/teacher/materi/{{ Request::segment(3) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-body">
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                        <div class="col-sm-12 col-md-7">
                                            <input type="text" class="form-control" name="judul"
                                                value="{{ $materi->judul }}">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Description</label>
                                        <div class="col-sm-12 col-md-7">
                                            <textarea class="summernote" name="deskripsi"> {{ $materi->deskripsi }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label
                                            class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Thumbnail</label>
                                        <div class="col-sm-12 col-md-7">
                                            {{-- <div id="image-preview" class="image-preview">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="gambar" id="image-upload"
                                                    value="{{ $materi->gambar }}" />
                                            </div> --}}
                                            <div id="image-preview" class="image-preview"
                                                style="background-image: url('{{ asset('img/materi/' . $materi->gambar) }}') ; background-size: cover;
                                            background-position: center center;">
                                                <label for="image-upload" id="image-label">Choose Thumbnail</label>
                                                <input type="file" name="gambar" id="image-upload"
                                                    value="{{ asset('img/materi/' . $materi->gambar) }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Dokumen
                                            Tambahan (PPT / PDF)</label>
                                        <div class="col-sm-12 col-md-7">
                                            @if ($materi->file)
                                                <a href="{{ asset('file_upload/materi/' . $materi->file) }}"
                                                    class="btn btn-primary btn-md mb-3" target="_blank">
                                                    View File
                                                </a>
                                            @else
                                                <button class="btn btn-secondary mb-3" disabled>
                                                    <i>Tidak ada File Tambahan</i>
                                                </button>
                                            @endif

                                            <input type="file" class="form-control" name="file">
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                        <div class="col-sm-12 col-md-7">
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
    <script src="{{ asset('library/upload-preview/upload-preview.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-post-create.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
