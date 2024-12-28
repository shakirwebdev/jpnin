@include('modal.modal-bantuan')
<div id="page_top" class="section-body">
    <div class="container-fluid">
        <div class="page-header">
            <div class="left">
                <h1 class="page-title">@yield('title')</h1>
            </div>
            <div class="right d-block">
                <!-- <ul class="nav nav-pills">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Language</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#"><img class="w20 mr-2" src="{{ asset('assets/images/flags/my.svg') }}">Bahasa Melayu</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"><img class="w20 mr-2" src="{{ asset('assets/images/flags/us.svg') }}">English</a>
                        </div>
                    </li>
                </ul> -->
                @auth
                <div class="notification d-flex">
                    <div class="dropdown d-flex">
                        <span><b> {{ Auth::user()->profile->user_fullname }} </b></span>
                        <a class="nav-link icon d-block d-md-flex btn btn-default btn-icon ml-1" data-toggle="dropdown"><i class="fa fa-user"></i></a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a class="dropdown-item" href="{{ route('user.profile') }}"><i class="dropdown-icon fe fe-user"></i> Profile</a>
                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_bantuan"><i class="dropdown-icon fe fe-help-circle"></i> Bantuan?</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('authentication.dologout') }}"><i class="dropdown-icon fe fe-log-out"></i> Keluar</a>
                        </div>
                    </div>
                </div>
                @else
                <a class="dropdown-item" href="javascript:void(0)"><i class="dropdown-icon fe fe-help-circle"></i> Bantuan?</a>
                <a class="dropdown-item" href="{{ route('authentication.login') }}"><i class="dropdown-icon fe fe-unlock"></i> Log masuk</a>
                @endauth
            </div>
        </div>
    </div>
</div>


