<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Register &mdash; CBT BLK Mojokerto</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex align-items-stretch flex-wrap">
                <div
                    class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white d-flex flex-column justify-content-center">
                    <div class="m-3 p-4">
                        <div class="d-flex align-items-center mb-5">
                            <img src="{{ asset('img/jatim.png') }}" alt="logo" width="80"
                                class="shadow-light rounded-circle">
                            <h4 class="text-dark font-weight-normal ml-4">Tes Tulis BLK Mojokerto
                            </h4>
                        </div>

                        <form method="post" action="{{ route('register.action') }}" class="needs-validation"
                            novalidate>
                            @csrf
                            {{-- <input type="number" min="0" class="form-control" name="nomor_peserta"> --}}
                            <div class="form-group">
                                <label for="nomor_peserta">No. Peserta</label>
                                <input id="nomor_peserta" type="number" min="0" class="form-control"
                                    name="nomor_peserta" tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                    Please fill in your no peserta
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama_lengkap">Nama Lengkap</label>
                                <input id="nama_lengkap" type="text" class="form-control" name="nama_lengkap"
                                    tabindex="1" required autofocus>
                                <div class="invalid-feedback">
                                    Please fill in your full name
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control" name="email" tabindex="2"
                                    required>
                                <div class="invalid-feedback">
                                    Please fill in your email
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password"
                                    tabindex="3" required>
                                <div class="invalid-feedback">
                                    Please fill in your password
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pelatihan_id">Pilih Pelatihan</label>
                                <select id="pelatihan_id" class="form-control" name="pelatihan_id" tabindex="4"
                                    required>
                                    <option value="" disabled selected>Pilih Pelatihan</option>
                                    @foreach ($pelatihan as $list)
                                        <option value="{{ $list->id }}">{{ $list->nama }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please select a training program
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right w-100"
                                    tabindex="5">
                                    Register
                                </button>
                            </div>

                            <div class="mt-3 text-center">
                                Already have an account? <a href="/">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 min-vh-100 background-walk-y position-relative overlay-gradient-bottom order-1"
                    data-background="{{ asset('img/unsplash/register-bg.png') }}">
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/popper.js/dist/umd/popper.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>
