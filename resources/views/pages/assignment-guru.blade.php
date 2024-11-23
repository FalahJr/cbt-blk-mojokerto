@extends('layouts.app')

@section('title', 'Management Assignment')

@push('style')
    <!-- CSS Libraries -->
@endpush
<?php
use Illuminate\Support\Str;

?>

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Management Assignment</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Assignment</a></div>

                </div>
            </div>

            <div class="section-body">

                <div class="row">

                    <div class="col-12 ">
                        <a href="{{ route('add-assignment') }}" class="btn btn-success btn-block w-25 ">+ Add Assignment</a>
                        <div class="card mt-4">


                            <div class="card-body p-0">
                                <div class="table-responsive">

                                    <table class="table-striped table-md table">
                                        <tr>
                                            <th>#</th>
                                            <th>Judul</th>
                                            <th>Deskripsi</th>
                                            <th>File</th>
                                            <th>Created By</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php $no = 1; ?>

                                        @foreach ($data as $list)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $list->judul }}</td>

                                                <td>
                                                    {{ $list->deskripsi }}
                                                    {{-- {!! nl2br(htmlspecialchars_decode(Str::limit($list->deskripsi, 1000))) !!} --}}
                                                </td>
                                                <td>
                                                    {{-- {{ $list->file }} --}}

                                                    <a href="{{ asset('file_upload/assignment/' . $list->file) }}"
                                                        class="btn btn-primary btn-sm" download>
                                                        Download
                                                    </a>
                                                </td>
                                                <td>
                                                    Guru
                                                    {{-- {{ $list->nama_lengkap }} --}}
                                                </td>
                                                <td><a href="assignment/{{ $list->id }}/edit"
                                                        class="btn btn-secondary">Detail</a>
                                                    <form class="ml-auto mr-auto mt-3" method="POST"
                                                        action="/teacher/assignment/{{ $list->id }}">
                                                        {{ csrf_field() }}
                                                        @method('DELETE')
                                                        <button class="btn btn-danger">Delete</button>
                                                    </form>
                                                </td>
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
