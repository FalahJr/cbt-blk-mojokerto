@extends('layouts.app')

@section('title', 'Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Profile</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title text-capitalize">Hi, {{ $user->nama_lengkap }}!</h2>
                <p class="section-lead">
                    Change information about yourself on this page.
                </p>

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-5">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}"
                                    class="rounded-circle profile-widget-picture">

                            </div>
                            <div class="profile-widget-description">
                                <div class="profile-widget-name">{{ $user->nama_lengkap }} <div
                                        class="text-muted d-inline font-weight-normal">
                                        <div class="slash"></div> {{ $user->role }}
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="card">
                            <form class="form"
                                action="{{ Session('user')['role'] == 'Guru' ? '/teacher/profile' : '/student/profile' }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>Edit Profile</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <input type="text" class="form-control" value="{{ $user->id }}"
                                                required="" hidden name="id">
                                            <label>Name</label>
                                            <input type="text" class="form-control" value="{{ $user->nama_lengkap }}"
                                                required="" name="nama_lengkap">
                                            <div class="invalid-feedback">
                                                Please fill in the name
                                            </div>
                                        </div>
                                        {{-- <div class="form-group col-md-6 col-12">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control" value="Maman" required="">
                                            <div class="invalid-feedback">
                                                Please fill in the last name
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-7 col-12">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="{{ $user->email }}"
                                                required="" name="email">
                                            <div class="invalid-feedback">
                                                Please fill in the email
                                            </div>
                                        </div>
                                        <div class="form-group col-md-5 col-12">
                                            <label>Identification Number</label>
                                            <input type="tel" class="form-control" value="{{ $user->nomor_induk }}"
                                                name="nomor_induk">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label>Adrress</label>
                                            <textarea class="form-control" data-height="150" name="alamat">{{ $user->alamat }}</textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary" type="submit">Save Changes</button>
                                </div>
                            </form>
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

    <!-- Page Specific JS File -->
@endpush
