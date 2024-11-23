@extends('layouts.app')

@section('title', 'Material')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Material</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Material</div>
                </div>
            </div>

            <div class="section-body">

                <h2 class="section-title">All Materials</h2>
                <div class="row">
                    {{-- <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article article-style-b">
                            <div class="article-header">
                                <div class="article-image" data-background="{{ asset('img/news/img13.jpg') }}">
                                </div>
                                <div class="article-badge">
                                    <div class="article-badge-item bg-danger"><i class="fas fa-fire"></i> Trending</div>
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-title">
                                    <h2><a href="#">Excepteur sint occaecat cupidatat non proident</a></h2>
                                </div>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. </p>
                                <div class="article-cta">
                                    <a href="#">Read More <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </article>
                    </div> --}}
                    @foreach ($data as $list)
                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                            <article class="article article-style-b">
                                <div class="article-header">
                                    <div class="article-image" data-background="{{ asset('img/news/img15.jpg') }}">
                                    </div>
                                </div>
                                <div class="article-details">
                                    <div class="article-title">
                                        <h2 class="text-capitalize"><a href="#">{{ $list->judul }}</a></h2>
                                    </div>
                                    {{-- <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. </p> --}}
                                    <div class="article-cta">
                                        <a href="/student/detail-materi/{{ $list->id }}"
                                            class="btn btn-info w-100 mt-5">View <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach

                    {{-- <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article article-style-b">
                            <div class="article-header">
                                <div class="article-image" data-background="{{ asset('img/news/img07.jpg') }}">
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-title">
                                    <h2><a href="#">Excepteur sint occaecat cupidatat non proident</a></h2>
                                </div>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. </p>
                                <div class="article-cta">
                                    <a href="#">Read More <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </article>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article article-style-b">
                            <div class="article-header">
                                <div class="article-image" data-background="{{ asset('img/news/img02.jpg') }}">
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-title">
                                    <h2><a href="#">Excepteur sint occaecat cupidatat non proident</a></h2>
                                </div>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse
                                    cillum dolore eu fugiat nulla pariatur. </p>
                                <div class="article-cta">
                                    <a href="#">Read More <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </article>
                    </div> --}}
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
