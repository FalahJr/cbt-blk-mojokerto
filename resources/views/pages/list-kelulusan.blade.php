@extends('layouts.app')

@section('title', 'Management Kelulusan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Management Kelulusan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kelulusan</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 ">
                        <div class="card mt-4">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table-striped table-md table">
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Peserta</th>
                                            <th>Nilai Quiz</th>
                                            <th>Nilai Wawancara</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($kelulusan as $index => $data)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $data->user->nama_lengkap }}</td>
                                                <td>{{ $data->quizAttempt->score ?? 'N/A' }}</td>
                                                <td>{{ $data->nilai_wawancara }}</td>
                                                <td>
                                                    @if ($data->status == 'Lolos')
                                                        <span class="badge badge-success">Lolos</span>
                                                    @elseif ($data->status == 'Pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @elseif ($data->status == 'Tidak Lolos')
                                                        <span class="badge badge-danger">Tidak Lolos</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('kelulusan.edit', $data->id) }}"
                                                        class="btn btn-primary">Update</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                {{ $kelulusan->links() }}
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
