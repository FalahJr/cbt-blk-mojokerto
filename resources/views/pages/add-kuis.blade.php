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
                <h1>Add Quiz</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Materi</a></div>
                    <div class="breadcrumb-item">Add Materi</div>
                </div>
            </div>

            <div class="section-body">


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Add Quiz</h4>
                            </div>
                            <form class="form" action="{{ route('quizzes.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group ">
                                        <label class="">Title</label>
                                        <div class=" ">
                                            <input type="text" class="form-control" name="title">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Choose Material</label>
                                        <select class="form-control select2" name="materi_id">
                                            <option value="" hidden>Choose Material</option>
                                            @foreach ($materis as $list)
                                                <option value="{{ $list->id }}">{{ $list->judul }}</option>
                                            @endforeach
                                            {{-- <option>Option 2</option>
                                            <option>Option 3</option> --}}
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Timer</label>
                                        <div class=" ">
                                            <input type="number" class="form-control" name="timer">
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
