@extends('layouts.app')

@section('title', 'Management Instruktur')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Management Instruktur</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Instruktur</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('add-guru') }}" class="btn btn-success btn-block w-25">+ Tambah Instruktur</a>

                        <!-- Form Pencarian -->
                        <form action="{{ route('manage-guru.index') }}" method="GET" class="mt-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Cari nama instruktur..." value="{{ request('search') }}">
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
                                                <th>Nama Lengkap</th>
                                                <th>Email</th>
                                                <th>Jenis Pelatihan</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($data as $index => $list)
                                                <tr>
                                                    <td>{{ $data->firstItem() + $index }}</td>
                                                    <td>{{ $list->nama_lengkap }}</td>
                                                    <td>{{ $list->email }}</td>
                                                    <td>{{ $list->nama }}</td>
                                                    <td>
                                                        <a href="manage-guru/{{ $list->id }}/edit"
                                                            class="btn btn-secondary">Detail</a>
                                                        <form class="d-inline" method="POST"
                                                            action="/admin/manage-guru/{{ $list->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
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
