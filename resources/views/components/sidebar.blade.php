<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html" class="" style="width:100%">
                <img alt="image" class="rounded-circle mr-1" width="50" src="{{ asset('img/logo-lms.png') }}">
                <span style="width: 50%">CBT BLK Mojokerto</span>
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">
                <img alt="image" class="rounded-circle" width="50" src="{{ asset('img/logo-lms.png') }}">
            </a>
        </div>
        <div class="d-flex flex-column justify-content-between" style="height: 90vh">
            <ul class="sidebar-menu">
                @if (Session('user')['role'] == 'Murid')
                    <li class="{{ Request::is('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('student/home') }}"><i class="fas fa-th-large"></i>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="{{ Request::is('quizzes') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('student/quizzes') }}"><i class="fas fa-file-pen"></i>
                            <span>Quiz</span></a>
                    </li>
                @endif
                @if (Session('user')['role'] == 'Guru')
                    <li class="{{ Request::is('/teacher/home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('teacher/home') }}"><i class="fas fa-th-large"></i>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('teacher/materi') }}"><i class="fas fa-home"></i>
                            <span>Material</span></a>
                    </li>
                    <li class="{{ Request::is('quizzes/score') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('teacher/quiz') }}"><i class="fas fa-file-pen"></i>
                            <span>Result Quiz</span></a>
                    </li>
                    <li class="{{ Request::is('manage-student') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('teacher/manage-student') }}"><i class="fas fa-user"></i>
                            <span>Manage Students</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                class="fas fa-columns"></i>
                            <span>Manage Quiz</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ Request::is('teacher/quizzes') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('teacher/quizzes') }}">Quiz</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                class="fas fa-columns"></i>
                            <span>Assignment</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ Request::is('teacher/assignment') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('teacher/assignment') }}">Manage Assignment</a>
                            </li>
                            <li class="{{ Request::is('submission/') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('teacher/assignments/submission/') }}">Result</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if (Session('user')['role'] == 'Admin')
                    <li class="{{ Request::is('/admin/home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/home') }}"><i class="fas fa-th-large"></i>
                            <span>Dashboard</span></a>
                    </li>
                    <li class="{{ Request::is('admin/periode') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/periode') }}"><i class="fas fa-home"></i>
                            <span>Periode</span></a>
                    </li>
                    <li class="{{ Request::is('admin/kategori-pelatihan') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/kategori-pelatihan') }}"><i class="fas fa-home"></i>
                            <span>Kategori Pelatihan</span></a>
                    </li>
                    <li class="{{ Request::is('quizzes/score') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/quiz') }}"><i class="fas fa-file-pen"></i>
                            <span>Hasil Ujian</span></a>
                    </li>
                    <li class="{{ Request::is('manage-student') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/manage-student') }}"><i class="fas fa-user"></i>
                            <span>Manajemen Peserta</span></a>
                    </li>
                    <li class="{{ Request::is('manage-guru') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ url('admin/manage-guru') }}"><i class="fas fa-user"></i>
                            <span>Manajemen Guru</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i
                                class="fas fa-columns"></i>
                            <span>Manage Quiz</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{ Request::is('admin/quizzes') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ url('admin/quizzes') }}">Quiz</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </aside>
</div>
