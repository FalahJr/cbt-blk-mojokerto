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
                <div class="col-9">
                    <div class="section-header flex-column align-items-start ">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <h1>My Students</h1>
                            <a href="{{ url('teacher/manage-student') }}">View All</a>
                        </div>
                        <div class="d-flex justify-content-center align-items-center w-100 mt-5">

                            @foreach ($listMurid as $list)
                                {{-- <div class="col-3"> --}}
                                <article class="article article-style-b mr-4" style="width: 15vw">
                                    <div class="article-header">
                                        <div class="article-image"
                                            data-background="
                                        @if ($list->gambar) {{ asset('img/murid/' . $list->gambar) }}
                                        @else
                                        {{ asset('img/news/img15.jpg') }} @endif
                                       ">
                                        </div>
                                    </div>
                                    <div class="article-details">
                                        <div class="article-title">
                                            <h2 class="text-capitalize"><a href="#">{{ $list->nama_lengkap }}</a>
                                            </h2>
                                        </div>

                                    </div>
                                </article>
                                {{-- </div> --}}
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12 col-12 col-sm-12">
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
                </div>
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
