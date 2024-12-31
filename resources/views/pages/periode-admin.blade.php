@extends('layouts.app')

@section('title', 'Management Materi')

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
                <h1>Management Periode</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Periode</a></div>

                </div>
            </div>

            <div class="section-body">

                <div class="row">

                    <div class="col-12 ">
                        @if (Session('user')['role'] == 'Admin')
                            <a href="{{ route('add-periode') }}" class="btn btn-success btn-block w-25 ">+ Tambah
                                Periode</a>
                        @endif
                        <div class="card mt-4">


                            <div class="card-body p-0">
                                <div class="table-responsive">

                                    <table class="table-striped table-md table">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Periode</th>
                                            {{-- <th>Deskripsi</th> --}}
                                            {{-- <th>Created By</th> --}}
                                            @if (Session('user')['role'] == 'Admin')
                                                <th>Action</th>
                                            @endif
                                        </tr>
                                        <?php $no = 1; ?>

                                        @foreach ($data as $list)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $list->nama }}</td>

                                                {{-- <td>
                                                    {!! nl2br(htmlspecialchars_decode(Str::limit($list->deskripsi, 1000))) !!}

                                                </td> --}}
                                                @if (Session('user')['role'] == 'Admin')
                                                    <td class="d-flex"><a href="periode/{{ $list->id }}/edit"
                                                            class="btn btn-secondary">Detail</a>
                                                        <form class="ml-2" method="POST"
                                                            action="/admin/periode/{{ $list->id }}">
                                                            {{ csrf_field() }}
                                                            @method('DELETE')
                                                            <button class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                @endif
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
