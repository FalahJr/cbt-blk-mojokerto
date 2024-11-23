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
                <h1>Add Question</h1>
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
                                <h4>Form Add Question</h4>
                            </div>
                            <form class="form" action="{{ route('questions.store', $quiz->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group ">
                                        <label class="">Question</label>
                                        <div class=" ">
                                            <input type="text" class="form-control" name="question">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Option A</label>
                                        <div class=" ">
                                            <input type="text" class="form-control" name="option_a">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Option B</label>
                                        <div class=" ">
                                            <input type="text" class="form-control" name="option_b">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Option C</label>
                                        <div class=" ">
                                            <input type="text" class="form-control" name="option_c">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Option D</label>
                                        <div class=" ">
                                            <input type="text" class="form-control" name="option_d">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Option E</label>
                                        <div class=" ">
                                            <input type="text" class="form-control" name="option_e">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Correct Answer</label>
                                        <select class="form-control select2" name="correct_answer"
                                            placeholder="Correct Answer">
                                            <option value="" hidden>Correct Answer</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>

                                        </select>
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
