
<style>
    .metismenu.grid>li>a {
        height: 110px;
    }
    .display-table {
        /*display: table-cell;
        padding-left: 30px;*/
    }
    .jabatan {
        font-family: "Open Sans"; 
        font-size: 14px; 
        font-style: normal; 
        font-variant: normal; 
        font-weight: 600;
    }
</style>
<div id="left-sidebar" class="sidebar" style="height: 100vh; display: none;">
    <div class="text-center">
        <img src="{{ asset('assets/images/jata.png') }}" width="130px">
        <br>
        <div class="jabatan" style="padding-top: 8px;">
            JABATAN PERPADUAN NEGARA DAN INTEGRASI NASIONAL
        </div>
    </div>
    <h5 class="brand-name">&nbsp;<a href="javascript:void(0)" class="menu_toggle float-right"><i class="fa fa-angle-double-left font-16" data-toggle="tooltip" data-placement="left" title="Hide"></i></a></h5>
    <nav id="left-sidebar-nav" class="sidebar-nav" style="width: 100%; height: 100vh; overflow: scroll; ">
        <ul class="metismenu">
        <li class="{{ Request::segment(2) === 'index' ? 'active' : null }}"><a href="{{route('dashboard.index')}}"><i class="icon-screen-desktop"></i><span>Dashboard</span></a></li>
            {{-- Foreach menu item starts --}}
            @php
                $url = null;
                $temp = null;
                $temp_menu2 = null;
            @endphp
            {{-- {{dd($roles_menu)}} --}}
            @foreach($roles_menu as $item)
                @php
                    $url = request()->route($item->menu_url);
                @endphp
                @if($temp==null)
                    @php
                        $temp = $item->first_menu;
                    @endphp
                    <!-- <li class="{{ Request::segment(2) === $item->highlight_menu ? 'active' : null }}"><a href="{{$url}}"><i class="{{ $item->icon_menu }}"></i><span>{{ $item->nama_menu }}</span></a> -->
                @else
                    @if($temp !== $item->first_menu && $item->second_menu == null)
                        @php
                            $temp = $item->first_menu;
                        @endphp
                        @if($temp_menu2 == 1)
                            @php
                                $temp_menu2 = null;
                            @endphp
                            </ul>
                        @else
                            @php
                                $temp_menu2 = null;
                            @endphp
                        @endif
                        </li>
                        <li class="{{ Request::segment(2) === $item->highlight_menu ? 'active' : null }}"><a href="{{$url}}" class="has-arrow arrow-c"><i class="{{ $item->icon_menu }}"></i><span>{{ $item->nama_menu }}</span></a>
                    @else
                        @if($temp == $item->first_menu && $item->second_menu !== null)
                            @if($temp_menu2 == null)
                                @php
                                    $temp_menu2 = 1;
                                @endphp
                                <ul>
                            @endif
                            <li class="{{ Request::segment(3) === $item->highlight_menu ? 'active' : null }}"><a href="{{route( $item->menu_url ) }}"><i class="{{ $item->icon_menu }}"></i><span>{{ $item->nama_menu }}</span></a></li>
                        @endif
                        
                    @endif



                    
                @endif
            @endforeach
            {{-- Foreach menu item ends --}}
        </ul>
    </nav>        
</div>
<!-- sss -->