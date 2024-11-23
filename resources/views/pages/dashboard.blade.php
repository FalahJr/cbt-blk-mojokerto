@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/fullcalendar/dist/fullcalendar.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="d-flex flex-column">
                    <h1>Dashboard</h1>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="section-header">
                        <div class="d-flex flex-column">
                            <h1>HALO !!!</h1>
                            <p>Yuk kita belajar bersama</p>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Calendar</h4>
                        </div>
                        <div class="card-body">
                            <div class="fc-overflow">
                                <div id="myEvent"></div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="section-header flex-column align-items-start ">
                <div class="d-flex flex-column">
                    <h1>Announcement</h1>
                </div>
                <div class="col-12">
                    <div class="card  py-1 mt-4 " style="background-color: #D4DEFF; border-radius:20px">

                        <div class="card-wrap">

                            <div class="card-body text-dark d-flex justify-content-between align-items-center ">

                                <div>
                                    <h6 class="text-capitalize">
                                        Hello {{ Session('user')['nama'] }}
                                    </h6>
                                    <h6>
                                        {{ $newest_notifikasi->judul }}
                                    </h6>
                                </div>
                                <div>
                                    <a href="/student/materi/" class="btn btn-primary btn-lg rounded-pill">
                                        Open
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="section-header flex-column align-items-start ">
                        <div class="d-flex flex-column">
                            <h1>Assignments</h1>
                        </div>
                        <div class="col-12">
                            <div class="card bg-light secondary pt-3 px-4 mt-4 " style=" border-radius:20px">

                                <div class="card-wrap">

                                    <div class="card-body text-dark d-flex justify-content-between align-items-center ">
                                        <div>
                                            <h6 class="">
                                                Chemistry
                                            </h6>
                                            <p>
                                                Chapter 5 </p>
                                        </div>

                                        <div>
                                            <h6 class="">
                                                Daily task
                                            </h6>
                                            <p>
                                                Page 10 </p>
                                        </div>
                                        <div>
                                            <h6>
                                                11.00 AM
                                            </h6>
                                        </div>
                                        <div class="text-warning">
                                            <h6>
                                                Pending
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Leaderboard</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($list_leaderboard as $list_ranking)
                                    <li class="media">
                                        <img class="rounded-circle mr-3" width="50"
                                            src="{{ asset('img/avatar/avatar-1.png') }}" alt="avatar">
                                        <div class="media-body">

                                            <div class="media-title">{{ $list_ranking->nama_lengkap }}</div>
                                            <span class="text-small text-muted">Score {{ $list_ranking->score }}</span>
                                        </div>
                                    </li>
                                @endforeach


                            </ul>
                            <div class="pt-1 pb-1 text-center">
                                <a href="#" class="btn btn-primary btn-lg btn-round">
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>


        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <!-- JS Libraies -->
    <script src="{{ asset('library/fullcalendar/dist/fullcalendar.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-calendar.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
