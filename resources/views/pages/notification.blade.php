@extends('layouts.app')

@section('title', 'Material')

@push('style')
    <!-- CSS Libraries -->
@endpush
<?php
use Carbon\Carbon;

?>

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1 class="text-capitalize">List Notification</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a
                            href="/{{ Session('user')['role'] == 'Guru' ? 'teacher' : 'student' }}/home">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#"> List Notification </a></div>
                </div>
            </div>

            <div class="section-body w-50">
                @foreach ($newest_notifikasi as $list)
                    <div class="activity-detail bg-white py-3 px-4">
                        <div class="mb-2">
                            <span
                                class="text-job text-primary">{{ Carbon::parse($list->created_at)->format('d F Y') }}</span>
                            <span class="bullet"></span>

                        </div>
                        <h6 class="text-dark" href="#">{{ $list->judul }}</h6>

                        <p>{{ $list->deskripsi }}</p>
                    </div>
                @endforeach


            </div>
        </section>
    </div>

@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
