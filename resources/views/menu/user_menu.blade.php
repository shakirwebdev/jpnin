<li class="{{ Request::segment(2) === 'index' ? 'active' : null }}"><a href="{{route('dashboard.index')}}"><i class="icon-screen-desktop"></i><span>Dashboard</span></a></li>

@include('js.menu.j-user-menu')