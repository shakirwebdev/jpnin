<style>
    @media screen and (min-width: 768px) {
        .rotated {
            writing-mode: tb-rl;
            transform: rotate(-180deg);
            margin-left: -28px;
            margin-top: -20px;
        }
    }
    
</style>
<div id="header_top" class="header_top dark" style="display: none;">
    <div class="container">
        <div class="hleft">
            <div class="rotated">
                <a class="header-brand" href="/"><h4 class="nav-link">SISTEM MAKLUMAT PERPADUAN</h4></a>
            </div>
        </div>
        <div class="hright">
            <div class="dropdown">
                <a href="javascript:void(0)" class="nav-link icon settingbar"><i class="fa fa-gear fa-spin" data-toggle="tooltip" data-placement="right" title="Ubah paparan"></i></a>
                @auth
                <!-- <a href="javascript:void(0)" class="nav-link user_btn"><img class="avatar" src="{{ asset('assets/images/shield.png') }}" alt="" data-toggle="tooltip" data-placement="right" title="Info Pengguna"/></a> -->
                @else
                <a href="{{ route('authentication.login') }}" class="nav-link user_btn"><img class="avatar" src="{{ asset('assets/images/unshield.png') }}" alt="" data-toggle="tooltip" data-placement="right" title="Log masuk"/></a>                
                @endauth
                <a href="javascript:void(0)" class="nav-link icon menu_toggle"><i class="fa fa-align-left"></i></a>
            </div>
        </div>
    </div>
</div>