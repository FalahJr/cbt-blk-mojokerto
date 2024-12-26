@extends('layouts.app')

@section('title', 'Management Peserta')

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
                <h1>Management Peserta</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Peserta</a></div>

                </div>
            </div>

            <div class="section-body">

                <div class="row">

                    <div class="col-12 ">
                        @if (Session('user')['role'] == 'Admin')
                            <a href="{{ route('add-student') }}" class="btn btn-success btn-block w-25 ">+ Tambah
                                Peserta</a>
                        @endif
                        <form action="{{ route('manage-student.index') }}" method="GET" class="my-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari Nama Peserta"
                                    value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                </div>
                            </div>
                        </form>
                        <div class="card mt-4">


                            <div class="card-body p-0">
                                <div class="table-responsive">

                                    <table class="table-striped table-md table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>No Peserta</th>
                                                <th>Nama Lengkap</th>
                                                <th>Email</th>
                                                <th>Jenis Pelatihan</th>
                                                @if (Session('user')['role'] == 'Admin')
                                                    <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $index => $list)
                                                <tr>
                                                    <td>{{ $data->firstItem() + $index }}</td>
                                                    <td>{{ $list->nomor_peserta }}</td>
                                                    <td>{{ $list->nama_lengkap }}</td>
                                                    <td>{{ $list->email }}</td>
                                                    <td>{{ $list->nama }}</td>
                                                    @if (Session('user')['role'] == 'Admin')
                                                        <td>
                                                            <a href="manage-student/{{ $list->id }}/edit"
                                                                class="btn btn-secondary">Detail</a>
                                                            <form class="d-inline" method="POST"
                                                                action="/admin/manage-student/{{ $list->id }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Data tidak ditemukan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Pagination -->
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    {!! $data->links() !!}
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
