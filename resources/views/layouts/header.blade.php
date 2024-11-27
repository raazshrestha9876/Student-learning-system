<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="{{ asset('dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="{{ asset('dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="{{ asset('dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">Student Sphere</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if(Auth::user()->is_role == 1)
                <li class="nav-item menu-open">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard<i class="right fas fa-angle-left"></i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/admin/list') }}" class="nav-link @if(Request::segment(2) == 'admin') active @endif">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>Admin</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/class/list') }}" class="nav-link @if(Request::segment(2) == 'class') active @endif">
                        <i class="nav-icon fas fa-school"></i>
                        <p>Class</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/subject/list') }}" class="nav-link @if(Request::segment(2) == 'subject') active @endif">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Subject</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link @if(Request::segment(2) == 'class_subject' || Request::segment(2) == 'teacher_class') active @endif" data-toggle="collapse" data-target="#curriculumSubMenu" aria-expanded="false">
                        <i class="nav-icon fas fa-clipboard-list"></i>
                        <p>Curriculum<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview collapse" id="curriculumSubMenu">
                        <li class="nav-item">
                            <a href="{{ url('admin/class_subject/list') }}" class="nav-link @if(Request::segment(2) == 'class_subject') active @endif">
                                <p>Class Subject</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/teacher_class/list') }}" class="nav-link @if(Request::segment(2) == 'teacher_class') active @endif">
                                <p>Teacher Class</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/student/list') }}" class="nav-link @if(Request::segment(2) == 'student') active @endif">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p>Student</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/attendance/classes') }}" class="nav-link @if(Request::segment(2) == 'attendance') active @endif">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Attendance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('chat') }}" class="nav-link @if(Request::segment(2) == 'chat') active @endif">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Chat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('logout') }}" class="nav-link @if(Request::segment(2) == 'logout') active @endif">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
                @elseif(Auth::user()->is_role == 2)
                <li class="nav-item menu-open">
                    <a href="{{ url('teacher/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard<i class="right fas fa-angle-left"></i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('teacher/profile') }}" class="nav-link @if(Request::segment(2) == 'profile') active @endif">
                        <i class="nav-icon fas fa-user"></i>
                        <p>My Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('teacher/timeline') }}" class="nav-link @if(Request::segment(2) == 'timeline') active @endif">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Course</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('teacher/assignment/list') }}" class="nav-link @if(Request::segment(2) == 'assignment') active @endif">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Assignments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('teacher/quiz/index') }}" class="nav-link @if(Request::segment(2) == 'quiz') active @endif">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Quiz</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('chat') }}" class="nav-link @if(Request::segment(2) == 'chat') active @endif">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Chat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('logout') }}" class="nav-link @if(Request::segment(2) == 'logout') active @endif">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
                @elseif(Auth::user()->is_role == 3)
                <li class="nav-item menu-open">
                    <a href="{{ url('student/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard<i class="right fas fa-angle-left"></i></p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('student/profile') }}" class="nav-link @if(Request::segment(2) == 'profile') active @endif">
                        <i class="nav-icon fas fa-user"></i>
                        <p>My Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('student/assignment') }}" class="nav-link @if(Request::segment(2) == 'assignment') active @endif">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Assignments</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('student/attendance/view') }}" class="nav-link @if(Request::segment(2) == 'attendance') active @endif">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Attendance</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('student/quiz/index') }}" class="nav-link @if(Request::segment(2) == 'quiz') active @endif">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Quiz</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('chat') }}" class="nav-link @if(Request::segment(2) == 'chat') active @endif">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>Chat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('logout') }}" class="nav-link @if(Request::segment(2) == 'logout') active @endif">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>