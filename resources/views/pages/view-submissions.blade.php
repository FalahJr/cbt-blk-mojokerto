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
                @if (Session('user')['role'] == 'Murid')
                    <h1>Hasil Quiz</h1>
                @else
                    <h1>List Submissions</h1>
                @endif
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Assignment</a></div>
                    <div class="breadcrumb-item">All Submissions</div>
                </div>
            </div>

            <div class="section-body">


                <div class="row">



                    <div class="col-12 ">



                        <div class="card-body p-0">
                            <div class="table-responsive">

                                <table class="table-striped table-md table text-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Date of Collection</th>
                                        <th>File Submission</th>
                                    </tr>
                                    <?php $no = 1; ?>

                                    @foreach ($data as $list)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td class="text-capitalize">{{ $list['nama_lengkap'] }}</td>

                                            <td>

                                                @if ($list['status'] == 'Belum Mengumpulkan')
                                                    <span class="badge badge-danger w-75">{{ $list['status'] }}</span>
                                                @elseif ($list['status'] == 'Terlambat')
                                                    <span class="badge badge-warning w-75">{{ $list['status'] }}</span>
                                                @else
                                                    <span class="badge badge-success w-75">{{ $list['status'] }}</span>
                                                @endif


                                            </td>
                                            <td>
                                                {{ $list['tgl_submit'] }}
                                            </td>
                                            <td>
                                                @if ($list['file'])
                                                    <a href="{{ asset('file_upload/submission/' . $list['file']) }}"
                                                        class="btn btn-primary btn-sm" download>
                                                        Download
                                                    </a>
                                                @else
                                                    <button class="btn btn-dark btn-sm disabled" disabled>
                                                        Download
                                                    </button>
                                                @endif

                                            </td>

                                        </tr>
                                        <?php $no++; ?>
                                    @endforeach


                                </table>
                            </div>
                        </div>
                        {{-- <div class="card-footer text-right">
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
                        </div> --}}
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
