@extends('layouts.app')

@section('title', 'Material')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-capitalize">{{ $materi->judul }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="/student/materi"> Material </a></div>
                </div>
            </div>

            <div class="section-body d-flex justify-content-center w-100">
                <div class="w-25 bg-white mr-2 px-4 py-3">
                    <h6>Lihat File Tambahan (PPT / PDF)</h6>
                    @if ($materi->file)
                        <a href="{{ asset('file_upload/materi/' . $materi->file) }}" class="btn btn-primary btn-md mb-3"
                            target="_blank">
                            View File
                        </a>
                    @else
                        <button class="btn btn-secondary mb-3" disabled>
                            <i>Tidak ada File Tambahan</i>
                        </button>
                    @endif
                </div>
                <div class=" bg-white px-5 w-75 ">
                    {!! nl2br(htmlspecialchars_decode($materi->deskripsi)) !!}
                </div>

            </div>
        </section>
    </div>
    <script>
        function logEndTime() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", '{{ route('materi.logEndTime') }}', false); // 'false' makes the request synchronous
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            xhr.send(JSON.stringify({
                log_id: {{ $activityLog->id }}
            }));
        }

        window.addEventListener('beforeunload', function(e) {
            logEndTime();
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('a').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    logEndTime();
                });
            });
        });
    </script>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
