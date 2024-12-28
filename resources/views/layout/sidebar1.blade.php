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
            <!-- <li class="{{ Request::segment(2) === 'index' ? 'active' : null }}"><a href="{{route('dashboard.index')}}"><i class="icon-screen-desktop"></i><span>Dashboard</span></a></li>
            
            @guest
            <li class="{{ Request::segment(2) === 'register' ? 'active' : null }}"><a href="{{route('authentication.register')}}"><i class="icon-note"></i><span>Akaun Baru</span></a></li>
            @endauth -->
            
            @if(\App\User::isOrangAwam())
                <li class="{{ Request::segment(2) === 'sm1' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan KRT Baharu</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-penubuhan-krt' ? 'active' : null }}"><a href="{{route('rt-sm1.permohonan_penubuhan_krt')}}">Permohonan Cadangan Nama KRT</a></li>
                        <li class="{{ Request::segment(3) === 'status-permohonan-penubuhan-krt' ? 'active' : null }}"><a href="{{route('rt-sm1.status_permohonan_penubuhan_krt')}}">aaa Status Permohonan Penubuhan KRT</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isPPD())
                <li class="{{ Request::segment(2) === 'sm1' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan KRT Baharu</span></a>
                    <ul>
                       <li class="{{ Request::segment(3) === 'semakan-cadangan-krt-baharu' ? 'active' : null }}"><a href="{{route('rt-sm1.semakan_cadangan_krt_baharu')}}">Semakan Cadangan Penubuhan KRT</a></li>
                       <li class="{{ Request::segment(3) === 'semakan-permohonan-krt-baharu' ? 'active' : null }}"><a href="{{route('rt-sm1.semakan_permohonan_krt_baharu')}}">Semakan Permohonan Penubuhan KRT Baharu</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm2' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Profil KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'profile-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm2.profile_krt_ppd')}}">Senarai Profil KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm4' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelantikan Rukun Tetangga</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pengesahan-ahli-krt-utama' ? 'active' : null }}"><a href="{{route('rt-sm4.pengesahan_ahli_krt_utama')}}">Pengesahan Ahli AJK KRT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ajk-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm4.senarai_ajk_krt_ppd')}}">Jana Surat Pelantikan Anggota</a></li>
                        <!-- <li class="{{ Request::segment(3) === 'pengesahan-cadangan-ajk-kepentingan-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm4.pengesahan_cadangan_ajk_kepentingan_krt_ppd')}}">Pengesahan Cadangan AJK Kepentingan KRT</a></li> -->
                        <!-- <li class="{{ Request::segment(3) === 'jana-analisa-lampiran' ? 'active' : null }}"><a href="{{route('rt-sm4.jana_analisa_lampiran')}}">Jana Analisa Lampiran</a></li> -->
                        <li class="{{ Request::segment(3) === 'kad-keahlian-ppd' ? 'active' : null }}"><a href="{{route('rt-sm4.kad_keahlian_ppd')}}">Kad Keahlian e-IDRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm5' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Minit Mesyurat RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pengesahan-minit-mesyuarat-rt' ? 'active' : null }}"><a href="{{route('rt-sm5.pengesahan_minit_mesyuarat_rt')}}">Pengesahan Minit Mesyuarat Jawatankuasa</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm6' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Aktiviti RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'surat-perancangan-aktiviti-ppd' ? 'active' : null }}"><a href="{{route('rt-sm6.surat_perancangan_aktiviti_ppd')}}">Jana Surat Perancangan Aktiviti KRT</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-perancangan-aktiviti-ppd' ? 'active' : null }}"><a href="{{route('rt-sm6.pengesahan_perancangan_aktiviti_ppd')}}">Pengesahan Perancangan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-perancangan-aktiviti-ppd' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_perancangan_aktiviti_ppd')}}">Jana Laporan Perancangan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-laporan-aktiviti-ppd' ? 'active' : null }}"><a href="{{route('rt-sm6.pengesahan_laporan_aktiviti_ppd')}}">Pengesahan Laporan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-aktiviti-ppd' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_aktiviti_ppd')}}">Jana Laporan Aktiviti</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm7' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Kewangan RT</span></a>
                    <ul>
                    <li class="{{ Request::segment(3) === 'pengesahan-rekod-kewangan-rt' ? 'active' : null }}"><a href="{{route('rt-sm7.pengesahan_rekod_kewangan_rtrt-sm7.pengesahan_rekod_kewangan_rt')}}">Pengesahan &amp; Kuiri Kewangan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm8' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'semakan-pembatalan-krt' ? 'active' : null }}"><a href="{{route('rt-sm8.semakan_pembatalan_krt')}}">Semakan Pembatalan KRT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-pembatalan-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm8.senarai_pembatalan_krt_ppd')}}">Senarai Pembatalan KRT Diluluskan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm9' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Cawangan RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'menyemak-ajk-cawangan-rt' ? 'active' : null }}"><a href="{{route('rt-sm9.menyemak_ajk_cawangan_rt')}}">Menyemak AJK Cawangan RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ajk-cawangan-rt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm9.senarai_ajk_cawangan_rt_ppd')}}">Senarai AJK Cawangan RT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Agenda Kerja Komuniti</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'semakan-profil-skuad-uniti-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.semakan_profil_skuad_uniti_krt')}}">Semakan Permohonan Skuad Uniti</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-skuad-uniti-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_skuad_uniti_krt_ppd')}}">Senarai Skuad Uniti</a></li>
                        <li class="{{ Request::segment(3) === 'semakan-sejiwa-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.semakan_sejiwa_krt')}}">Semakan Permohonan Sejiwa</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sejiwa-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_sejiwa_krt_ppd')}}">Senarai Sejiwa</a></li>
                        <li class="{{ Request::segment(3) === 'semakan-projek-ekonomi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.semakan_projek_ekonomi_krt')}}">Semakan Permohonan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-projek-ekonomi-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_projek_ekonomi_krt_ppd')}}">Senarai Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'semakan-projek-ekonomi-st-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.semakan_projek_ekonomi_st_krt')}}">Semakan Pelaksanaan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-pelaksanaan-projek-ekonomi-ppd' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_pelaksanaan_projek_ekonomi_ppd')}}">Senarai Pelaksanaan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'semakan-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.semakan_koperasi_krt')}}">Semakan Permohonan Koperasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-koperasi-ppd' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_koperasi_ppd')}}">Senarai Koperasi</a></li>
                        <li class="{{ Request::segment(3) === 'permohonan-kanta-komuniti' ? 'active' : null }}"><a href="{{route('rt-sm10.permohonan_kanta_komuniti')}}">Permohonan Kanta Komuniti</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-kanta-komuniti-ppd' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_kanta_komuniti_ppd')}}">Analisa Laporan Kanta Komuniti</a></li>
                        <li class="{{ Request::segment(3) === 'semakan-isu-lokasi-kanta-komuniti' ? 'active' : null }}"><a href="{{route('rt-sm10.semakan_isu_lokasi_kanta_komuniti')}}">Semakan Isu Dan Masalah Di Lokasi Kanta Komuniti</a></li>
                        <li class="{{ Request::segment(3) === 'analisa-isu-lokasi-kanta-komuniti' ? 'active' : null }}"><a href="{{route('rt-sm10.analisa_isu_lokasi_kanta_komuniti')}}">Analisa Isu Dan Masalah Di Lokasi Kanta Komuniti</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm11' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Keaktifan & Pemulihan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'keaktifan-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm11.keaktifan_krt_ppd')}}">Senarai Keaktifan KRT</a></li>
                        <li class="{{ Request::segment(3) === 'pemulihan-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm11.pemulihan_krt_ppd')}}">Senarai Pemulihan KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm12' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'semak-permohonan-penubuhan-srs' ? 'active' : null }}"><a href="{{route('rt-sm12.semak_permohonan_penubuhan_srs')}}">Semak Permohonan Penubuhan SRS</a></li>
                        <!-- <li class="{{ Request::segment(3) === 'jana-surat-terima-permohonan-srs' ? 'active' : null }}"><a href="{{route('rt-sm12.jana_surat_terima_permohonan_srs')}}">Jana Surat Akuan Terima Permohonan SRS</a></li> -->
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm13' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Ahli Peronda SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'semak-pendaftaran-ahli-peronda-srs-ppd' ? 'active' : null }}"><a href="{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs_ppd')}}">Semak Pendaftaran Ahli Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ahli-peronda-srs-ppd' ? 'active' : null }}"><a href="{{route('rt-sm13.senarai_ahli_peronda_srs_ppd')}}">Senarai Ahli Peronda SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm14' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Operasi Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'paparan-pemakluman-ops-rondaan-ppd' ? 'active' : null }}"><a href="{{route('rt-sm14.paparan_pemakluman_ops_rondaan_ppd')}}">Paparan Pemakluman Mula Operasi Rondaan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm15' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Perancangan Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'jana-jadual-rondaan-ppd' ? 'active' : null }}"><a href="{{route('rt-sm15.jana_jadual_rondaan_ppd')}}">Jana Jadual Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-perancangan-rondaan-ppd' ? 'active' : null }}"><a href="{{route('rt-sm15.laporan_perancangan_rondaan_ppd')}}">Laporan Perancangan Kekerapan Rondaan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm16' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelaksanaan<br> Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pengesahan-pelaksanaan-rondaan-srs' ? 'active' : null }}"><a href="{{route('rt-sm16.pengesahan_pelaksanaan_rondaan_srs')}}">Pengesahan Pelaksanaan Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-pelaksanaan-rondaan-ppd' ? 'active' : null }}"><a href="{{route('rt-sm16.laporan_pelaksanaan_rondaan_ppd')}}">Laporan Pelaksanaan Kekerapan Rondaan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm18' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penarikan Diri<br> Ahli SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pengesahan-penarikan-diri-ahli-srs' ? 'active' : null }}"><a href="{{route('rt-sm18.pengesahan_penarikan_diri_ahli_srs')}}">Pengesahan Penarikan Diri SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm19' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'semakan-pembatalan-srs-ppd' ? 'active' : null }}"><a href="{{route('rt-sm19.semakan_pembatalan_srs_ppd')}}">Semakan Pembatalan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm30' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-maklumat-asas-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_maklumat_asas_krt_ppd')}}">Laporan Maklumat Asas RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-krt-ppd' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_krt_ppd')}}">Laporan AJK KRT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-bilangan-ajk-jawatan-ppd' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_bilangan_ajk_jawatan_ppd')}}">Bilangan AJK KRT Mengikut Jawatan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-pendidikan-ppd' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_pendidikan_ppd')}}">Laporan AJK Mengikut Pendidikan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-kaum-ppd' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_kaum_ppd')}}">Laporan AJK Mengikut Kaum</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-pekerjaan-ppd' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_pekerjaan_ppd')}}">Laporan AJK Mengikut Pekerjaan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-jantina-ppd' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_jantina_ppd')}}">Laporan AJK Mengikut Jantina</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm31' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-srs-ppd' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_srs_ppd')}}">Laporan Senarai SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(1) === 'pengurusan' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-wrench"></i><span>Modul Utiliti</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'pengguna-ppd' ? 'active' : null }}"><a href="{{route('pengurusan.pengguna_ppd')}}">Pengurusan Pengguna</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isPPN())
                <li class="{{ Request::segment(2) === 'sm1' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan KRT Baharu</span></a>
                    <ul>
                       <li class="{{ Request::segment(3) === 'pengesahan-permohonan-krt-baharu' ? 'active' : null }}"><a href="{{route('rt-sm1.pengesahan_permohonan_krt_baharu')}}">Pengesahan Permohonan Penubuhan KRT Baharu</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm2' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Profil KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'profile-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm2.profile_krt_ppn')}}">Senarai Profil KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm4' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelantikan Rukun Tetangga</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-ajk-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm4.senarai_ajk_krt_ppn')}}">Jana Surat Pelantikan Anggota</a></li>
                        <li class="{{ Request::segment(3) === 'kad-keahlian-ppn' ? 'active' : null }}"><a href="{{route('rt-sm4.kad_keahlian_ppn')}}">Kad Keahlian e-IDRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm6' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Aktiviti RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'surat-perancangan-aktiviti-ppn' ? 'active' : null }}"><a href="{{route('rt-sm6.surat_perancangan_aktiviti_ppn')}}">Jana Surat Perancangan Aktiviti KRT</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-perancangan-aktiviti-ppn' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_perancangan_aktiviti_ppn')}}">Jana Laporan Perancangan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-aktiviti-ppn' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_aktiviti_ppn')}}">Jana Laporan Aktiviti</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm8' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'sokongan-pembatalan-krt' ? 'active' : null }}"><a href="{{route('rt-sm8.sokongan_pembatalan_krt')}}">Sokongan Pembatalan KRT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-pembatalan-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm8.senarai_pembatalan_krt_ppn')}}">Senarai Pembatalan KRT Diluluskan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm9' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Cawangan RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'memperakui-ajk-cawangan-rt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm9.memperakui_ajk_cawangan_rt_ppn')}}">Memperakui AJK Cawangan RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ajk-cawangan-rt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm9.senarai_ajk_cawangan_rt_ppn')}}">Senarai AJK Cawangan RT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Agenda Kerja Komuniti</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'akui-profil-skuad-uniti-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.akui_profil_skuad_uniti_krt')}}">Perakui Permohonan Skuad Uniti</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-skuad-uniti-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_skuad_uniti_krt_ppn')}}">Senarai Skuad Uniti</a></li>
                        <li class="{{ Request::segment(3) === 'akui-sejiwa-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.akui_sejiwa_krt')}}">Perakui Permohonan Sejiwa</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sejiwa-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_sejiwa_krt_ppn')}}">Senarai Sejiwa</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-projek-ekonomi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.pengesahan_projek_ekonomi_krt')}}">Pengesahan Permohonan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-projek-ekonomi-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_projek_ekonomi_krt_ppn')}}">Senarai Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-projek-ekonomi-st-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.pengesahan_projek_ekonomi_st_krt')}}">Pengesahan Pelaksanaan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-pelaksanaan-projek-ekonomi-ppn' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_pelaksanaan_projek_ekonomi_ppn')}}">Senarai Pelaksanaan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.pengesahan_koperasi_krt')}}">Pengesahan Permohonan Koperasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-koperasi-ppn' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_koperasi_ppn')}}">Senarai Koperasi</a></li>
                        <li class="{{ Request::segment(3) === 'semakan-kanta-komuniti' ? 'active' : null }}"><a href="{{route('rt-sm10.semakan_kanta_komuniti')}}">Semakan Permohonan Kanta Komuniti</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-kanta-komuniti-ppn' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_kanta_komuniti_ppn')}}">Analisa Laporan Kanta Komuniti</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-isu-lokasi-kanta-komuniti' ? 'active' : null }}"><a href="{{route('rt-sm10.pengesahan_isu_lokasi_kanta_komuniti')}}">Pengesahan Isu Dan Masalah Di Lokasi Kanta Komuniti</a></li>
                        <li class="{{ Request::segment(3) === 'analisa-isu-lokasi-kanta-komuniti-ppn' ? 'active' : null }}"><a href="{{route('rt-sm10.analisa_isu_lokasi_kanta_komuniti_ppn')}}">Analisa Isu Dan Masalah Di Lokasi Kanta Komuniti</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm11' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Keaktifan & Pemulihan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'keaktifan-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm11.keaktifan_krt_ppn')}}">Senarai Keaktifan KRT</a></li>
                        <li class="{{ Request::segment(3) === 'pemulihan-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm11.pemulihan_krt_ppn')}}">Senarai Semakan Pemulihan KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm12' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pengesahan-permohonan-penubuhan-srs' ? 'active' : null }}"><a href="{{route('rt-sm12.pengesahan_permohonan_penubuhan_srs')}}">Pengesahan Permohonan Penubuhan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm13' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Ahli Peronda SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-ahli-peronda-srs-ppn' ? 'active' : null }}"><a href="{{route('rt-sm13.senarai_ahli_peronda_srs_ppn')}}">Senarai Ahli Peronda SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm14' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Operasi Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'paparan-pemakluman-ops-rondaan-ppn' ? 'active' : null }}"><a href="{{route('rt-sm14.paparan_pemakluman_ops_rondaan_ppn')}}">Paparan Pemakluman Mula Operasi Rondaan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm15' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Perancangan Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'jana-jadual-rondaan-ppn' ? 'active' : null }}"><a href="{{route('rt-sm15.jana_jadual_rondaan_ppn')}}">Jana Jadual Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-perancangan-rondaan-ppn' ? 'active' : null }}"><a href="{{route('rt-sm15.laporan_perancangan_rondaan_ppn')}}">Laporan Perancangan Kekerapan Rondaan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm16' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelaksanaan<br> Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-pelaksanaan-rondaan-ppn' ? 'active' : null }}"><a href="{{route('rt-sm16.laporan_pelaksanaan_rondaan_ppn')}}">Laporan Pelaksanaan Kekerapan Rondaan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm19' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pengesahan-pembatalan-srs-ppn' ? 'active' : null }}"><a href="{{route('rt-sm19.pengesahan_pembatalan_srs_ppn')}}">Pengesahan Pembatalan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm30' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-maklumat-asas-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_maklumat_asas_krt_ppn')}}">Laporan Maklumat Asas RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-krt-ppn' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_krt_ppn')}}">Laporan AJK KRT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-bilangan-ajk-jawatan-ppn' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_bilangan_ajk_jawatan_ppn')}}">Bilangan AJK KRT Mengikut Jawatan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-pendidikan-ppn' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_pendidikan_ppn')}}">Laporan AJK Mengikut Pendidikan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-kaum-ppn' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_kaum_ppn')}}">Laporan AJK Mengikut Kaum</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-pekerjaan-ppn' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_pekerjaan_ppn')}}">Laporan AJK Mengikut Pekerjaan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-jantina-ppn' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_jantina_ppn')}}">Laporan AJK Mengikut Jantina</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm31' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-srs-ppn' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_srs_ppn')}}">Laporan Senarai SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-peronda-srs-ppn' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_peronda_srs_ppn')}}">Laporan Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ringkasan-peronda-srs-ppn' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_ringkasan_peronda_srs_ppn')}}">Laporan Ringkasan Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-rondaan-srs-ppn' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_rondaan_srs_ppn')}}">Laporan Keaktifan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-pengendalian-kes-srs-ppn' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_pengendalian_kes_srs_ppn')}}">Laporan Pengendalian Kes SRS</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isHQRT())
                <li class="{{ Request::segment(2) === 'sm1' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan KRT Baharu</span></a>
                    <ul>
                       <li class="{{ Request::segment(3) === 'kelulusan-permohonan-krt-baharu' ? 'active' : null }}"><a href="{{route('rt-sm1.kelulusan_permohonan_krt_baharu')}}">Kelulusan Permohonan Penubuhan KRT Baharu</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm2' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Profil KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'profile-krt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm2.profile_krt_hqrt')}}">Senarai Profil KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm4' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelantikan Rukun Tetangga</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'kad-keahlian-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm4.kad_keahlian_hqrt')}}">Kad Keahlian e-IDRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm6' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Aktiviti RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'surat-perancangan-aktiviti-hq' ? 'active' : null }}"><a href="{{route('rt-sm6.surat_perancangan_aktiviti_hq')}}">Jana Surat Perancangan Aktiviti KRT</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-perancangan-aktiviti-hq' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_perancangan_aktiviti_hq')}}">Jana Laporan Perancangan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-aktiviti-hq' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_aktiviti_hq')}}">Jana Laporan Aktiviti</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm8' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'kelulusan-pembatalan-krt' ? 'active' : null }}"><a href="{{route('rt-sm8.kelulusan_pembatalan_krt')}}">Kelulusan Pembatalan KRT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-pembatalan-krt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm8.senarai_pembatalan_krt_hqrt')}}">Senarai Pembatalan KRT Diluluskan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Agenda Kerja Komuniti</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-skuad-uniti-krt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_skuad_uniti_krt_hqrt')}}">Senarai Skuad Uniti</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sejiwa-krt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_sejiwa_krt_hqrt')}}">Senarai Sejiwa</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-projek-ekonomi-krt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_projek_ekonomi_krt_hqrt')}}">Senarai Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-pelaksanaan-projek-ekonomi-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_pelaksanaan_projek_ekonomi_hqrt')}}">Senarai Pelaksanaan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-koperasi-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_koperasi_hqrt')}}">Senarai Koperasi</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-kanta-komuniti' ? 'active' : null }}"><a href="{{route('rt-sm10.pengesahan_kanta_komuniti')}}">Pengesahan Permohonan Kanta Komuniti</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-kanta-komuniti-hq' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_kanta_komuniti_hq')}}">Analisa Laporan Kanta Komuniti</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm11' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Keaktifan & Pemulihan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'keaktifan-krt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm11.keaktifan_krt_hqrt')}}">Senarai Keaktifan KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm30' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-maklumat-asas-krt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_maklumat_asas_krt_hqrt')}}">Laporan Maklumat Asas RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-krt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_krt_hqrt')}}">Laporan AJK KRT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-bilangan-ajk-jawatan-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_bilangan_ajk_jawatan_hqrt')}}">Bilangan AJK KRT Mengikut Jawatan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-pendidikan-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_pendidikan_hqrt')}}">Laporan AJK Mengikut Pendidikan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-kaum-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_kaum_hqrt')}}">Laporan AJK Mengikut Kaum</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-pekerjaan-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_pekerjaan_hqrt')}}">Laporan AJK Mengikut Pekerjaan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-jantina-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_jantina_hqrt')}}">Laporan AJK Mengikut Jantina</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-skuad-uniti-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_skuad_uniti_hqrt')}}">Laporan Maklumat Skuad Uniti</a></li>
                        <!-- <li class="{{ Request::segment(3) === 'laporan-penduduk-rt-kaum-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_penduduk_rt_kaum_hqrt')}}">Laporan Penduduk RT Mengikut Kaum</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-sosio-ekonomi-rt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_sosio_ekonomi_rt_hqrt')}}">Laporan Sosio Ekonomi Pekerjaan Penduduk</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-kategori-rumah-rt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_kategori_rumah_rt_hqrt')}}">Laporan Kategori Rumah RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-kemudahan-rt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_kemudahan_rt_hqrt')}}">Laporan Kemudahan, Isu, Masalah dan Petanian RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-binaan-jabatan-rt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_binaan_jabatan_rt_hqrt')}}">Laporan Bagunan Binaan Jabatan RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-binaan-tumpang-rt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_binaan_tumpang_rt_hqrt')}}">Laporan Bagunan Tumpang RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-binaan-sewa-rt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_binaan_sewa_rt_hqrt')}}">Laporan Bagunan Sewa RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-kabin-rt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_kabin_rt_hqrt')}}">Laporan Senarai Kabin RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-kekerapan-mesyuarat-rt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_kekerapan_mesyuarat_rt_hqrt')}}">Laporan Kekerapan Mesyuarat RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-maklumat-perbankan-rt-hqrt' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_maklumat_perbankan_rt_hqrt')}}">Laporan Maklumat Perbankan RT</a></li> -->
                    </ul>
                </li>
            @elseif(\App\User::isHQSRS())
                <li class="{{ Request::segment(2) === 'sm12' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'peraku-permohonan-penubuhan-srs' ? 'active' : null }}"><a href="{{route('rt-sm12.peraku_permohonan_penubuhan_srs')}}">Peraku Permohonan Penubuhan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm13' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Ahli Peronda SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-ahli-peronda-srs-hq' ? 'active' : null }}"><a href="{{route('rt-sm13.senarai_ahli_peronda_srs_hq')}}">Senarai Ahli Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'kad-keahlian-hqsrs' ? 'active' : null }}"><a href="{{route('rt-sm13.kad_keahlian_hqsrs')}}">Kad Keahlian E-IDRT (SRS)</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm19' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'kelulusan-pembatalan-srs-hq' ? 'active' : null }}"><a href="{{route('rt-sm19.kelulusan_pembatalan_srs_hq')}}">Kelulusan Pembatalan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'notis-pembatalan-srs-hq' ? 'active' : null }}"><a href="{{route('rt-sm19.notis_pembatalan_srs_hq')}}">Jana Notis Pembatalan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm31' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-srs-hqsrs' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_srs_hqsrs')}}">Laporan Senarai SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-peronda-srs-hqsrs' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_peronda_srs_hqsrs')}}">Laporan Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ringkasan-peronda-srs-hqsrs' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_ringkasan_peronda_srs_hqsrs')}}">Laporan Ringkasan Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-rondaan-srs-hqsrs' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_rondaan_srs_hqsrs')}}">Laporan Keaktifan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-pengendalian-kes-srs-hqsrs' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_pengendalian_kes_srs_hqsrs')}}">Laporan Pengendalian Kes SRS</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isKetuaPengarahHQ())
                <li class="{{ Request::segment(2) === 'sm12' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'kelulusan-permohonan-penubuhan-srs' ? 'active' : null }}"><a href="{{route('rt-sm12.kelulusan_permohonan_penubuhan_srs')}}">Kelulusan Permohonan Penubuhan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm30' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-maklumat-asas-krt-kp' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_maklumat_asas_krt_kp')}}">Laporan Maklumat Asas RT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-krt-kp' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_krt_kp')}}">Laporan AJK KRT</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-bilangan-ajk-jawatan-kp' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_bilangan_ajk_jawatan_kp')}}">Bilangan AJK KRT Mengikut Jawatan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-pendidikan-kp' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_pendidikan_kp')}}">Laporan AJK Mengikut Pendidikan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-kaum-kp' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_kaum_kp')}}">Laporan AJK Mengikut Kaum</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-pekerjaan-kp' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_pekerjaan_kp')}}">Laporan AJK Mengikut Pekerjaan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ajk-jantina-kp' ? 'active' : null }}"><a href="{{route('rt-sm30.laporan_ajk_jantina_kp')}}">Laporan AJK Mengikut Jantina</a></li>

                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm31' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-srs-kp' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_srs_kp')}}">Laporan Senarai SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-peronda-srs-kp' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_peronda_srs_kp')}}">Laporan Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ringkasan-peronda-srs-kp' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_ringkasan_peronda_srs_kp')}}">Laporan Ringkasan Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-rondaan-srs-kp' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_rondaan_srs_kp')}}">Laporan Keaktifan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-pengendalian-kes-srs-kp' ? 'active' : null }}"><a href="{{route('rt-sm31.laporan_pengendalian_kes_srs_kp')}}">Laporan Pengendalian Kes SRS</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isPengerusi())
                <li class="{{ Request::segment(2) === 'sm2' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Profil KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'profile-krt' ? 'active' : null }}"><a href="{{route('rt-sm2.profile_krt')}}">Kemaskini Profil KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm4' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelantikan AJK KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pendaftaran-ahli-krt-utama' ? 'active' : null }}"><a href="{{route('rt-sm4.pendaftaran_ahli_krt_utama')}}">Pendaftaran AJK KRT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ajk-krt' ? 'active' : null }}"><a href="{{route('rt-sm4.senarai_ajk_krt')}}">Senarai AJK KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm5' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Minit Mesyurat RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-minit-mesyuarat-rt' ? 'active' : null }}"><a href="{{route('rt-sm5.senarai_minit_mesyuarat_rt')}}">Penyediaan Minit Mesyuarat Jawatankuasa</a></li>
                        <li class="{{ Request::segment(3) === 'paparan-minit-mesyuarat-rt' ? 'active' : null }}"><a href="{{route('rt-sm5.paparan_minit_mesyuarat_rt')}}">Paparan Minit Mesyuarat Jawatankuasa</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm6' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Aktiviti RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'surat-perancangan-aktiviti-krt' ? 'active' : null }}"><a href="{{route('rt-sm6.surat_perancangan_aktiviti_krt')}}">Jana Surat Perancangan Aktiviti KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm7' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Kewangan RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'semakan-rekod-kewangan-rt' ? 'active' : null }}"><a href="{{route('rt-sm7.semakan_rekod_kewangan_rt')}}">Semakan Penerimaan &amp; Pengeluaran Kewangan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm8' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-pembatalan-krt' ? 'active' : null }}"><a href="{{route('rt-sm8.permohonan_pembatalan_krt')}}">Permohonan Pembatalan KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm9' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Cawangan RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-ajk-cawangan-rt' ? 'active' : null }}"><a href="{{route('rt-sm9.senarai_ajk_cawangan_rt')}}">Senarai AJK Cawangan RT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Agenda Kerja Komuniti</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-skuad-uniti-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_skuad_uniti_krt')}}">Senarai Skuad Uniti</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sejiwa-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_sejiwa_krt')}}">Senarai Sejiwa</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-projek-ekonomi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_projek_ekonomi_krt')}}">Senarai Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-pelaksanaan-projek-ekonomi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_pelaksanaan_projek_ekonomi_krt')}}">Senarai Pelaksanaan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_koperasi_krt')}}">Senarai Koperasi</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm11' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Keaktifan & Pemulihan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'keaktifan-krt' ? 'active' : null }}"><a href="{{route('rt-sm11.keaktifan_krt')}}">Senarai Keaktifan KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm12' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-srs' ? 'active' : null }}"><a href="{{route('rt-sm12.senarai_srs')}}">Senarai SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm14' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Operasi Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pemakluman-ops-rondaan-srs' ? 'active' : null }}"><a href="{{route('rt-sm14.pemakluman_ops_rondaan_srs')}}">Pemakluman Mula Operasi Rondaan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm19' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-pembatalan-srs-p' ? 'active' : null }}"><a href="{{route('rt-sm19.permohonan_pembatalan_srs_p')}}">Permohonan Pembatalan SRS</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isSetiausaha())
                <li class="{{ Request::segment(2) === 'sm4' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelantikan AJK KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pendaftaran-ahli-krt-utama' ? 'active' : null }}"><a href="{{route('rt-sm4.pendaftaran_ahli_krt_utama')}}">Pendaftaran AJK KRT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ajk-krt' ? 'active' : null }}"><a href="{{route('rt-sm4.senarai_ajk_krt')}}">Senarai AJK KRT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm5' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Minit Mesyurat RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-minit-mesyuarat-rt' ? 'active' : null }}"><a href="{{route('rt-sm5.senarai_minit_mesyuarat_rt')}}">Penyediaan Minit Mesyuarat Jawatankuasa</a></li>
                        <li class="{{ Request::segment(3) === 'paparan-minit-mesyuarat-rt' ? 'active' : null }}"><a href="{{route('rt-sm5.paparan_minit_mesyuarat_rt')}}">Paparan Minit Mesyuarat Jawatankuasa</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm6' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Aktiviti RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'surat-perancangan-aktiviti-krt' ? 'active' : null }}"><a href="{{route('rt-sm6.surat_perancangan_aktiviti_krt')}}">Jana Surat Perancangan Aktiviti KRT</a></li>
                        <li class="{{ Request::segment(3) === 'penyediaan-perancangan-aktiviti-krt' ? 'active' : null }}"><a href="{{route('rt-sm6.penyediaan_perancangan_aktiviti_krt')}}">Penyediaan Perancangan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-perancangan-aktiviti-krt' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_perancangan_aktiviti_krt')}}">Jana Laporan Perancangan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'penyediaan-laporan-aktiviti-krt' ? 'active' : null }}"><a href="{{route('rt-sm6.penyediaan_laporan_aktiviti_krt')}}">Penyediaan Laporan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-aktiviti-krt' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_aktiviti_krt')}}">Jana Laporan Aktiviti</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm9' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Cawangan RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'tambah-ajk-cawangan-rt' ? 'active' : null }}"><a href="{{route('rt-sm9.tambah_ajk_cawangan_rt')}}">Tambah AJK Cawangan RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ajk-cawangan-rt' ? 'active' : null }}"><a href="{{route('rt-sm9.senarai_ajk_cawangan_rt')}}">Senarai AJK Cawangan RT</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Agenda Kerja Komuniti</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'profil-skuad-uniti-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.profil_skuad_uniti_krt')}}">Permohonan Skuad Uniti</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-skuad-uniti-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_skuad_uniti_krt')}}">Senarai Skuad Uniti</a></li>
                        <li class="{{ Request::segment(3) === 'permohonan-sejiwa-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.permohonan_sejiwa_krt')}}">Permohonan Sejiwa</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sejiwa-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_sejiwa_krt')}}">Senarai Sejiwa</a></li>
                        <li class="{{ Request::segment(3) === 'permohonan-projek-ekonomi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.permohonan_projek_ekonomi_krt')}}">Permohonan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-projek-ekonomi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_projek_ekonomi_krt')}}">Senarai Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'pelaksanaan-projek-ekonomi-st-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.pelaksanaan_projek_ekonomi_st_krt')}}">Pelaksanaan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-pelaksanaan-projek-ekonomi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_pelaksanaan_projek_ekonomi_krt')}}">Senarai Pelaksanaan Projek Ekonomi RT</a></li>
                        <li class="{{ Request::segment(3) === 'permohonan-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.permohonan_koperasi_krt')}}">Permohonan Koperasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_koperasi_krt')}}">Senarai Koperasi</a></li>
                        <li class="{{ Request::segment(3) === 'isu-lokasi-kanta-komuniti-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.isu_lokasi_kanta_komuniti_krt')}}">Melapor Isu Dan Masalah Di Lokasi Kanta Komuniti</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isBendahari())
                <li class="{{ Request::segment(2) === 'sm7' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Kewangan RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-rekod-kewangan-rt' ? 'active' : null }}"><a href="{{route('rt-sm7.senarai_rekod_kewangan_rt')}}">Rekod Penerimaan &amp; Pengeluaran Kewangan</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-rekod-kewangan-rt-diluluskan' ? 'active' : null }}"><a href="{{route('rt-sm7.senarai_rekod_kewangan_rt_diluluskan')}}">Paparan Rekod Penerimaan &amp; Pengeluaran Kewangan</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isKetuaPeronda())
                <li class="{{ Request::segment(2) === 'sm13' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Ahli Peronda SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-pendaftaran-ahli-peronda-srs' ? 'active' : null }}"><a href="{{route('rt-sm13.senarai_pendaftaran_ahli_peronda_srs')}}">Pendaftaran Ahli Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ahli-peronda-srs' ? 'active' : null }}"><a href="{{route('rt-sm13.senarai_ahli_peronda_srs')}}">Senarai Ahli Peronda SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm14' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Operasi Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'paparan-pemakluman-ops-rondaan-p' ? 'active' : null }}"><a href="{{route('rt-sm14.paparan_pemakluman_ops_rondaan_p')}}">Paparan Pemakluman Mula Operasi Rondaan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm15' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Perancangan Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'penyediaan-perancangan-rondaan-srs' ? 'active' : null }}"><a href="{{route('rt-sm15.penyediaan_perancangan_rondaan_srs')}}">Penyediaan Perancangan Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'jana-jadual-rondaan-k' ? 'active' : null }}"><a href="{{route('rt-sm15.jana_jadual_rondaan_k')}}">Jana Jadual Rondaan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm16' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelaksanaan<br> Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'penyediaan-pelaksanaan-rondaan-srs' ? 'active' : null }}"><a href="{{route('rt-sm16.penyediaan_pelaksanaan_rondaan_srs')}}">Penyediaan Pelaksanaan Rondaan SRS</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm18' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penarikan Diri<br> Ahli SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-penarikan-diri-ahli-srs' ? 'active' : null }}"><a href="{{route('rt-sm18.permohonan_penarikan_diri_ahli_srs')}}">Permohonan Penarikan Diri SRS</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isPPDeSepakat())
                <li class="{{ Request::segment(2) === 'sm21' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Kes</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-ikes' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_permohonan_ikes')}}">Permohonan Pelaporan i-Kes</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ts-ikes-ppd' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_ts_ikes_ppd')}}">Tindakan Susulan Pelaporan i-Kes</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm22' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Muhibbah</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-muhibbah-ppd' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_permohonan_muhibbah_ppd')}}">Permohonan Pelaporan i-Muhibbah</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ts-imuhibbah-ppd' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_ts_imuhibbah_ppd')}}">Tindakan Susulan Pelaporan i-Muhibbah</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm23' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Mediator</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-mkp-ppd' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_mkp_ppd')}}">Sokongan Permohonan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-dilantik-ppd' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_dilantik_ppd')}}">Senarai MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-semakan-laporan-mediasi-ppd' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_semakan_laporan_mediasi_ppd')}}">Sokongan Permohonan Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-mkp-keaktifan-ppd' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_mkp_keaktifan_ppd')}}">Sokongan Permohonan Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-keaktifan-ppd' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_keaktifan_ppd')}}">Senarai Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sokongan-pelanjutan-mkp-ppd' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_sokongan_pelanjutan_mkp_ppd')}}">Sokongan Permohonan Pelanjutan MKP</a></li>
                        
                    </ul>
                </li>
            @elseif(\App\User::isPPMKeSepakat())
                <li class="{{ Request::segment(2) === 'sm23' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Mediator</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-mkp-ppmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_mkp_ppmk')}}">Sokongan Permohonan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-dilantik-ppmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_dilantik_ppmk')}}">Senarai MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-semakan-laporan-mediasi-ppmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_semakan_laporan_mediasi_ppmk')}}">Sokongan Permohonan Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-mkp-keaktifan-ppmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_mkp_keaktifan_ppmk')}}">Sokongan Permohonan Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-keaktifan-ppmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_keaktifan_ppmk')}}">Senarai Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sokongan-pelanjutan-mkp-ppmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_sokongan_pelanjutan_mkp_ppmk')}}">Sokongan Permohonan Pelanjutan MKP</a></li>
                        
                    </ul>
                </li>
            @elseif(\App\User::isPPNeSepakat())
                <li class="{{ Request::segment(2) === 'sm21' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Kes</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-ikes-ppn' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_permohonan_ikes_ppn')}}">Permohonan Pelaporan i-Kes</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-akuan-permohonan-ikes-ppn' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_akuan_permohonan_ikes_ppn')}}">Memperakukan Permohonan Pelaporan i-Kes</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ts-ikes-ppn' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_ts_ikes_ppn')}}">Tindakan Susulan Pelaporan i-Kes</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm22' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Muhibbah</span></a>
                    <ul>
                    <li class="{{ Request::segment(3) === 'senarai-permohonan-muhibbah-ppn' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_permohonan_muhibbah_ppn')}}">Permohonan Pelaporan i-Muhibbah</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-akuan-permohonan-muhibbah-ppn' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_akuan_permohonan_muhibbah_ppn')}}">Memperakukan Permohonan Pelaporan i-Muhibbah</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ts-imuhibbah-ppn' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_ts_imuhibbah_ppn')}}">Tindakan Susulan Pelaporan i-Muhibbah</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm23' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Mediator</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-mkp-ppn' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_mkp_ppn')}}">Pengesahan Permohonan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-dilantik-ppn' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_dilantik_ppn')}}">Senarai MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-pengesahan-laporan-mediasi-ppn' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_pengesahan_laporan_mediasi_ppn')}}">Pengesahan Permohonan Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-mkp-keaktifan-ppn' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_mkp_keaktifan_ppn')}}">Pengesahan Permohonan Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-keaktifan-ppn' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_keaktifan_ppn')}}">Senarai Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sahkan-pelanjutan-mkp-ppn' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_sahkan_pelanjutan_mkp_ppn')}}">Pengesahan Permohonan Pelanjutan MKP</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isBPPeSepakat())
                <li class="{{ Request::segment(2) === 'sm21' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Kes</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-ikes-bpp' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_permohonan_ikes_bpp')}}">Permohonan Pelaporan i-Kes</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-semakan-permohonan-ikes-bpp' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_semakan_permohonan_ikes_bpp')}}">Menyemak Permohonan Pelaporan i-Kes</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm22' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Muhibbah</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-muhibbah-bpp' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_permohonan_muhibbah_bpp')}}">Permohonan Pelaporan i-Muhibbah</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-semakan-permohonan-muhibbah-bpp' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_semakan_permohonan_muhibbah_bpp')}}">Semakan Permohonan Pelaporan i-Muhibbah</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm32' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan e-Sepakat</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-ikes-isu-semasa-bpp' ? 'active' : null }}"><a href="{{route('rt-sm32.laporan_ikes_isu_semasa_bpp')}}">Laporan Isu - Isu Semasa</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ikes-bpp' ? 'active' : null }}"><a href="{{route('rt-sm32.laporan_ikes_bpp')}}">Laporan i-Kes</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-imuhibbah-bpp' ? 'active' : null }}"><a href="{{route('rt-sm32.laporan_imuhibbah_bpp')}}">Laporan i-Muhibbah</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isPengaraheSepakat())
                <li class="{{ Request::segment(2) === 'sm21' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Kes</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-sahkan-permohonan-ikes-p' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_sahkan_permohonan_ikes_p')}}">Pengesahan Permohonan Pelaporan i-Kes</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-at-ikes-p' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_at_ikes_p')}}">Arahan Tindakan i-Kes</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ts-ikes-p' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_ts_ikes_p')}}">Paparan Tindakan Susulan i-Kes</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm22' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Muhibbah</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-sahkan-permohonan-muhibbah-p' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_sahkan_permohonan_muhibbah_p')}}">Pengesahan Permohonan Pelaporan i-Muhibbah</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-at-imuhibbah-p' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_at_imuhibbah_p')}}">Arahan Tindakan i-Muhibbah</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ts-imuhibbah-p' ? 'active' : null }}"><a href="{{route('rt-sm22.senarai_ts_imuhibbah_p')}}">Paparan Tindakan Susulan i-Muhibbah</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm23' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Mediator</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-mkp-ppp' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_mkp_ppp')}}">Kelulusan Permohonan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-dilantik-ppp' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_dilantik_ppp')}}">Senarai MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-lulus-laporan-mediasi-pp' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_lulus_laporan_mediasi_pp')}}">Kelulusan Permohonan Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-laporan-kes-pp' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_laporan_kes_pp')}}">Senarai Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-keaktifan-p' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_keaktifan_p')}}">Senarai Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-kelulusan-pelanjutan-mkp-ppp' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_kelulusan_pelanjutan_mkp_ppp')}}">Kelulusan Permohonan Pelanjutan MKP</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm32' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="fa fa-line-chart"></i><span class="display-table">Laporan e-Sepakat</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'laporan-ikes-isu-semasa-p' ? 'active' : null }}"><a href="{{route('rt-sm32.laporan_ikes_isu_semasa_p')}}">Laporan Isu - Isu Semasa</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ikes-p' ? 'active' : null }}"><a href="{{route('rt-sm32.laporan_ikes_p')}}">Laporan i-Kes</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-imuhibbah-p' ? 'active' : null }}"><a href="{{route('rt-sm32.laporan_imuhibbah_p')}}">Laporan i-Muhibbah</a></li>
                    </ul>
                </li>
                
            @elseif(\App\User::isMKPeSepakat())
                <li class="{{ Request::segment(2) === 'sm23' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Mediator</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'mohon-pendaftaran-mkp' ? 'active' : null }}"><a href="{{route('rt-sm23.mohon_pendaftaran_mkp')}}">Permohonan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-laporan-mediasi' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_laporan_mediasi')}}">Permohonan Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'mohon-keaktifan-mkp' ? 'active' : null }}"><a href="{{route('rt-sm23.mohon_keaktifan_mkp')}}">Permohonan Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'permohonan-pelanjutan-mkp' ? 'active' : null }}"><a href="{{route('rt-sm23.permohonan_pelanjutan_mkp')}}">Permohonan Pelanjutan MKP</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isUPMKeSepakat())
                <li class="{{ Request::segment(2) === 'sm23' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Mediator</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-pra-pendaftaran-mkp-upmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_pra_pendaftaran_mkp_upmk')}}">Pra Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-mkp-upmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_mkp_upmk')}}">Semakan Permohonan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-dilantik-upmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_dilantik_upmk')}}">Senarai MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-semakan-laporan-mediasi-upmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_semakan_laporan_mediasi_upmk')}}">Semakan Permohonan Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-laporan-kes-upmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_laporan_kes_upmk')}}">Senarai Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-keaktifan-upmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_keaktifan_upmk')}}">Senarai Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-semakan-pelanjutan-mkp-upmk' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_semakan_pelanjutan_mkp_upmk')}}">Semakan Permohonan Pelanjutan MKP</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isKPeSepakat())
                <li class="{{ Request::segment(2) === 'sm23' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Mediator</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-mkp-kp' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_permohonan_mkp_kp')}}">Pelantikan Permohonan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-dilantik-kp' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_dilantik_kp')}}">Senarai MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-lantikan-pelanjutan-mkp-kp' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_lantikan_pelanjutan_mkp_kp')}}">Pelantikan Permohonan Pelanjutan MKP</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isIbu_Bapa())
                <li class="{{ Request::segment(2) === 'sm27' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>e-TP</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-student-tp-p' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_permohonan_student_tp_p')}}">Permohonan Kemasukan Tabika Perpaduan</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-student-tp-p' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_student_tp_p')}}">Semakan Status Permohonan</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isGuru())
                <li class="{{ Request::segment(2) === 'sm27' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>e-TP</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-student-tp-p' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_permohonan_student_tp_p')}}">Permohonan Kemasukan Tabika Perpaduan</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sah-mohon-student-tp-g' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_sah_mohon_student_tp_g')}}">Pengesahan Kemasukan Tabika Perpaduan</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-student-tp-g' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_student_tp_g')}}">Semakan Status Permohonan</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isPPDetp())
                <li class="{{ Request::segment(2) === 'sm27' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>e-TP</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-lulus-mohon-student-tp-ppd' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_lulus_mohon_student_tp_ppd')}}">Kelulusan Kemasukan Tabika Perpaduan</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-student-tp-ppd' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_student_tp_ppd')}}">Semakan Status Permohonan</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isHQUPAKK())
                <li class="{{ Request::segment(2) === 'sm27' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>e-TP</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-student-tp-hqtp' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_student_tp_hqtp')}}">Semakan Status Permohonan</a></li>
                    </ul>
                </li>
            @elseif(\App\User::isPKSIN())
                <li class="{{ Request::segment(2) === 'sm27' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>e-TP</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-student-tp-pksin' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_student_tp_pksin')}}">Semakan Status Permohonan</a></li>
                    </ul>
                </li>
            @else 
            
            @auth

                <li class="{{ Request::segment(2) === 'sm1' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan KRT Baharu</span></a>
                    <ul>
                        
                    </ul>
                </li>

                <li class="{{ Request::segment(2) === 'sm4' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelantikan Rukun Tetangga</span></a>
                    <ul>
                        
                    </ul>
                </li>

                <li class="{{ Request::segment(2) === 'sm5' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Minit Mesyurat RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'paparan-minit-mesyuarat-rt' ? 'active' : null }}"><a href="{{route('rt-sm5.paparan_minit_mesyuarat_rt')}}">Papar Minit Mesyuarat Jawatankuasa</a></li>
                    </ul>
                </li>
                
                <li class="{{ Request::segment(2) === 'sm6' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Aktiviti RT</span></a>
                    <ul>
                    <li class="{{ Request::segment(3) === 'surat-perancangan-aktiviti-admin' ? 'active' : null }}"><a href="{{route('rt-sm6.surat_perancangan_aktiviti_admin')}}">Jana Surat Perancangan Aktiviti KRT</a></li>
                        <li class="{{ Request::segment(3) === 'penyediaan-perancangan-aktiviti' ? 'active' : null }}"><a href="{{route('rt-sm6.penyediaan_perancangan_aktiviti')}}">Penyediaan Perancangan Aktiviti Perpaduan</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-perancangan-aktiviti' ? 'active' : null }}"><a href="{{route('rt-sm6.pengesahan_perancangan_aktiviti')}}">Pengesahan Perancangan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'penyediaan-laporan-aktiviti' ? 'active' : null }}"><a href="{{route('rt-sm6.penyediaan_laporan_aktiviti')}}">Penyediaan Laporan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-laporan-aktiviti' ? 'active' : null }}"><a href="{{route('rt-sm6.pengesahan_laporan_aktiviti')}}">Pengesahan Laporan Aktiviti</a></li>
                        <li class="{{ Request::segment(3) === 'jana-analisa-laporan-aktiviti' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_analisa_laporan_aktiviti')}}">Jana Analisa Laporan Aktiviti</a></li>
                        <!-- <li class="{{ Request::segment(3) === 'jana-laporan-perancangan-aktiviti-rt' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_perancangan_aktiviti_rt')}}">Jana Laporan Perancangan Aktiviti - RT</a></li> -->
                        <li class="{{ Request::segment(3) === 'jana-laporan-perancangan-aktiviti-daerah' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_perancangan_aktiviti_daerah')}}">Jana Laporan Perancangan Aktiviti - Daerah</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-perancangan-aktiviti-negeri' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_perancangan_aktiviti_negeri')}}">Jana Laporan Perancangan Aktiviti - Negeri</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-aktiviti-daerah' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_aktiviti_daerah')}}">Jana Laporan Aktiviti  - Daerah</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-aktiviti-negeri' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_aktiviti_negeri')}}">Jana Laporan Aktiviti  - Negeri</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-aktiviti-hq' ? 'active' : null }}"><a href="{{route('rt-sm6.jana_laporan_aktiviti_hq')}}">Jana Laporan Aktiviti  - HQ</a></li>
                    </ul>
                </li>

                <li class="{{ Request::segment(2) === 'sm7' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengurusan Kewangan RT</span></a>
                    <ul>
                        
                    </ul>
                </li>

                <li class="{{ Request::segment(2) === 'sm8' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan KRT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-pembatalan-krt-admin' ? 'active' : null }}"><a href="{{route('rt-sm8.permohonan_pembatalan_krt_admin')}}">Permohonan Pembatalan KRT</a></li>
                        <li class="{{ Request::segment(3) === 'semak-permohonan-pembatalan-krt-admin' ? 'active' : null }}"><a href="{{route('rt-sm8.semak_permohonan_pembatalan_krt_admin')}}">Semak Permohonan Pembatalan KRT</a></li>
                        <li class="{{ Request::segment(3) === 'sokongan-pembatalan-krt-admin' ? 'active' : null }}"><a href="{{route('rt-sm8.sokongan_pembatalan_krt_admin')}}">Sokongan Pembatalan KRT</a></li>
                        <li class="{{ Request::segment(3) === 'paparan-senarai-permohonan-krt-batal-admin' ? 'active' : null }}"><a href="{{route('rt-sm8.paparan_senarai_permohonan_krt_batal_admin')}}">Paparan Senarai Permohonan KRT Batal</a></li>
                        <li class="{{ Request::segment(3) === 'kelulusan-pembatalan-admin' ? 'active' : null }}"><a href="{{route('rt-sm8.kelulusan_pembatalan_admin')}}">Kelulusan Pembatalan</a></li>
                        <li class="{{ Request::segment(3) === 'jana-surat-kelulusan-pembatalan-admin' ? 'active' : null }}"><a href="{{route('rt-sm8.jana_surat_kelulusan_pembatalan_admin')}}">Jana Surat Kelulusan & Notis Pembatalan RT</a></li>
                        <li class="{{ Request::segment(3) === 'paparan-senarai-krt-batal-admin' ? 'active' : null }}"><a href="{{route('rt-sm8.paparan_senarai_krt_batal_admin')}}">Paparan Senarai KRT Batal</a></li>
                    </ul>
                </li>

                <li class="{{ Request::segment(2) === 'sm9' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Cawangan RT</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'tambah-ajk-cawangan-rt-admin' ? 'active' : null }}"><a href="{{route('rt-sm9.tambah_ajk_cawangan_rt_admin')}}">Tambah AJK Cawangan RT</a></li>
                        <li class="{{ Request::segment(3) === 'menyemak-ajk-cawangan-rt-admin' ? 'active' : null }}"><a href="{{route('rt-sm9.menyemak_ajk_cawangan_rt_admin')}}">Menyemak AJK Cawangan RT</a></li>
                        <li class="{{ Request::segment(3) === 'memperakui-ajk-cawangan-rt-admin' ? 'active' : null }}"><a href="{{route('rt-sm9.memperakui_ajk_cawangan_rt_admin')}}">Memperakui AJK Cawangan RT</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-ajk-cawangan-rt-admin' ? 'active' : null }}"><a href="{{route('rt-sm9.senarai_ajk_cawangan_rt_admin')}}">Senarai AJK Cawangan RT</a></li>
                    </ul>
                </li>

                <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Program Outcome Based Budgeting (OBB)</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                            <a href="javascript:void(0)" class="has-arrow arrow-c"><span class="display-table">Skuad Uniti</span></a>
                            <ul>
                                <li class="{{ Request::segment(3) === 'rekod-profil-skuad-unit' ? 'active' : null }}"><a href="{{route('rt-sm10.rekod_profil_skuad_unit')}}">Rekod Profil Skuad Uniti</a></li>
                                <li class="{{ Request::segment(3) === 'perancangan-aktivti-uniti' ? 'active' : null }}"><a href="{{route('rt-sm10.perancangan_aktivti_uniti')}}">Perancangan Aktiviti dan Perkhidmatan Skuad Uniti</a></li>
                                <li class="{{ Request::segment(3) === 'menyemak-perancangan-aktivti-uniti' ? 'active' : null }}"><a href="{{route('rt-sm10.menyemak_perancangan_aktivti_uniti')}}">Menyemak Perancangan Aktivti dan Perkhidmatan Skuad Uniti</a></li>
                                <li class="{{ Request::segment(3) === 'memperakui-perancangan-aktivti-uniti' ? 'active' : null }}"><a href="{{route('rt-sm10.memperakui_perancangan_aktivti_uniti')}}">Memperakui Perancangan Aktivti dan Perkhidmatan Skuad Uniti</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                            <a href="javascript:void(0)" class="has-arrow arrow-c"><span class="display-table">SeJIWA</span></a>
                            <ul>
                                <li class="{{ Request::segment(3) === 'rekod-profil-sejiwa' ? 'active' : null }}"><a href="{{route('rt-sm10.rekod_profil_sejiwa')}}">Rekod Profil SeJIWA</a></li>
                                <li class="{{ Request::segment(3) === 'perancangan-aktivti-sejiwa' ? 'active' : null }}"><a href="{{route('rt-sm10.perancangan_aktivti_sejiwa')}}">Perancangan Aktiviti dan Perkhidmatan SeJIWA</a></li>
                                <li class="{{ Request::segment(3) === 'menyemak-perancangan-aktivti-sejiwa' ? 'active' : null }}"><a href="{{route('rt-sm10.menyemak_perancangan_aktivti_sejiwa')}}">Menyemak Aktiviti dan Perkhidmatan SeJIWA</a></li>
                                <li class="{{ Request::segment(3) === 'memperakui-perancangan-aktivti-sejiwa' ? 'active' : null }}"><a href="{{route('rt-sm10.memperakui_perancangan_aktivti_sejiwa')}}">Memperakui Aktiviti dan Perkhidmatan SeJIWA</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                            <a href="javascript:void(0)" class="has-arrow arrow-c"><span class="display-table">Program Sayangi Komuniti</span></a>
                            <ul>
                                <li class="{{ Request::segment(3) === 'senarai-psk' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_psk')}}">Senarai PSK</a></li>
                                <li class="{{ Request::segment(3) === 'semakan-senarai-psk' ? 'active' : null }}"><a href="{{route('rt-sm10.semakan_senarai_psk')}}">Semakan Senarai PSK</a></li>
                                <li class="{{ Request::segment(3) === 'pengesahan-senarai-psk' ? 'active' : null }}"><a href="{{route('rt-sm10.pengesahan_senarai_psk')}}">Pengesahan Senarai PSK</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-laporan-aktivti-psk' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_laporan_aktivti_psk')}}">Penyediaan Laporan Aktiviti</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-laporan-aktivti-psk-ppd' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_laporan_aktivti_psk_ppd')}}">Pengesahan Laporan Aktiviti</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-laporan-isu-psk' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_laporan_isu_psk')}}">Penyediaan Laporan Isu Dan Masalah</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-laporan-isu-psk-ppd' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_laporan_isu_psk_ppd')}}">Semakan Laporan Isu Dan Masalah</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-laporan-isu-psk-ppn' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_laporan_isu_psk_ppn')}}">Pengesahan Laporan Isu Dan Masalah</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                            <a href="javascript:void(0)" class="has-arrow arrow-c"><span class="display-table">Projek Ekonomi RT</span></a>
                            <ul>
                                <li class="{{ Request::segment(3) === 'senarai-projek-ekonomi' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_projek_ekonomi')}}">Senarai Permohonan Projek Ekonomi RT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-semakan-projek-ekonomi-ppd' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_semakan_projek_ekonomi_ppd')}}">Senarai Semakan Projek Ekonomi RT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-pengesahan-projek-ekonomi-ppn' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_pengesahan_projek_ekonomi_ppn')}}">Senarai Pengesahan Projek Ekonomi RT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-laporan-projek-ekonomi' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_laporan_projek_ekonomi')}}">Senarai Laporan Kemajuan Projek Ekonomi RT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-semakan-laporan-projek-ekonomi' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_semakan_laporan_projek_ekonomi')}}">Senarai Semakan Laporan Kemajuan Projek Ekonomi RT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-pengesahan-laporan-projek-ekonomi' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_pengesahan_laporan_projek_ekonomi')}}">Senarai Pengesahan Laporan Kemajuan Projek Ekonomi RT</a></li>
                            </ul>
                        </li>
                        <li class="{{ Request::segment(2) === 'sm10' ? 'active' : null }}">
                            <a href="javascript:void(0)" class="has-arrow arrow-c"><span class="display-table">Projek Koperasi KRT</span></a>
                            <ul>
                                <li class="{{ Request::segment(3) === 'add-profile-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.add_profile_koperasi_krt')}}">Profil Koperasi KRT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-semakan-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_semakan_koperasi_krt')}}">Senarai Semakan Koperasi KRT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-pengesahan-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_pengesahan_koperasi_krt')}}">Senarai Pengesahan Koperasi KRT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-laporan-aktif-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_laporan_aktif_koperasi_krt')}}">Laporan Keaktifan Koperasi KRT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-p-laporan-aktif-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_p_laporan_aktif_koperasi_krt')}}">Pengesahan Laporan Keaktifan Koperasi KRT</a></li>
                                <li class="{{ Request::segment(3) === 'senarai-keaktifan-koperasi-krt' ? 'active' : null }}"><a href="{{route('rt-sm10.senarai_keaktifan_koperasi_krt')}}">Papar Keaktifan Koperasi KRT</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="{{ Request::segment(2) === 'sm11' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pemulihan KRT Tidak Aktif</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-laporan-pemulihan-krt-tidak-aktif' ? 'active' : null }}"><a href="{{route('rt-sm11.senarai_laporan_pemulihan_krt_tidak_aktif')}}">Senarai Pemulihan KRT Tidak Aktif</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-laporan-pemulihan-krt-tidak-aktif-ppn' ? 'active' : null }}"><a href="{{route('rt-sm11.senarai_laporan_pemulihan_krt_tidak_aktif_ppn')}}">Senarai Pengesahan Pemulihan KRT Tidak Aktif</a></li>
                    </ul>
                </li>

                <li class="{{ Request::segment(2) === 'sm12' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penubuhan SRS</span></a>
                    <ul>
                        
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm13' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Ahli Peronda SRS</span></a>
                    <ul>
                        
                        <li class="{{ Request::segment(3) === 'semak-pendaftaran-ahli-peronda-srs' ? 'active' : null }}"><a href="{{route('rt-sm13.semak_pendaftaran_ahli_peronda_srs')}}">Semak Pendaftaran Ahli Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'kad-keahlian-srs' ? 'active' : null }}"><a href="{{route('rt-sm13.kad_keahlian_srs')}}">Kad Keahlian E-IDRT (SRS)</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm14' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Operasi Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'pemakluman-operasi-rondaan' ? 'active' : null }}"><a href="{{route('rt-sm14.pemakluman_operasi_rondaan')}}">Hantar Pemakluman Mula Operasi Rondaan</a></li>
                        <li class="{{ Request::segment(3) === 'paparan-pemakluman-operasi-rondaan' ? 'active' : null }}"><a href="{{route('rt-sm14.paparan_pemakluman_operasi_rondaan')}}">Paparan Pemakluman Mula Operasi Rondaan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm15' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Perancangan Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'penyediaan-perancangan-rondaan' ? 'active' : null }}"><a href="{{route('rt-sm15.penyediaan_perancangan_rondaan')}}">Penyediaan Perancangan Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'jana-jadual-rondaan-srs' ? 'active' : null }}"><a href="{{route('rt-sm15.jana_jadual_rondaan_srs')}}">Jana Jadual Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-rondaan-srs' ? 'active' : null }}"><a href="{{route('rt-sm15.pengesahan_rondaan_srs')}}">Pengesahan Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'ringkasan-laporan-perancangan-rondaan' ? 'active' : null }}"><a href="{{route('rt-sm15.ringkasan_laporan_perancangan_rondaan')}}">Ringkasan Laporan Perancangan Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-kekerapan-rondaan-d' ? 'active' : null }}"><a href="{{route('rt-sm15.jana_laporan_kekerapan_rondaan_d')}}">Jana Laporan Kekerapan Rondaan SRS Daerah</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-kekerapan-rondaan-n' ? 'active' : null }}"><a href="{{route('rt-sm15.jana_laporan_kekerapan_rondaan_n')}}">Jana Laporan Kekerapan Rondaan SRS Negeri</a></li>
                        <!-- <li class="{{ Request::segment(3) === 'jana-laporan-kekerapan-rondaan-all' ? 'active' : null }}"><a href="{{route('rt-sm15.jana_laporan_kekerapan_rondaan_all')}}">Jana Laporan Kekerapan Rondaan SRS Keseluruhan</a></li> -->
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm16' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pelaksanaan Rondaan SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'penyediaan-pelaksanaan-rondaan' ? 'active' : null }}"><a href="{{route('rt-sm16.penyediaan_pelaksanaan_rondaan')}}">Penyediaan Pelaksanaan Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-kekerapan-pelaksanaan-rondaan' ? 'active' : null }}"><a href="{{route('rt-sm16.laporan_kekerapan_pelaksanaan_rondaan')}}">Jana Laporan Kekerapan Pelaksanaan Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-rondaan-srs' ? 'active' : null }}"><a href="{{route('rt-sm16.laporan_rondaan_srs')}}">Jana Laporan Rondaan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-kekerapan-pelaksanaan-rondaan-d' ? 'active' : null }}"><a href="{{route('rt-sm16.laporan_kekerapan_pelaksanaan_rondaan_d')}}">Jana Laporan Ringkasan Kekerapan Pelaksanaan Rondaan SRS Daerah</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-kekerapan-pelaksanaan-rondaan-n' ? 'active' : null }}"><a href="{{route('rt-sm16.laporan_kekerapan_pelaksanaan_rondaan_n')}}">Jana Laporan Ringkasan Kekerapan Pelaksanaan Rondaan SRS Negeri</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-kekerapan-pelaksanaan-rondaan-all' ? 'active' : null }}"><a href="{{route('rt-sm16.laporan_kekerapan_pelaksanaan_rondaan_all')}}">Jana Laporan Ringkasan Kekerapan Pelaksanaan Rondaan SRS Keseluruhan</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm17' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pengendali Kes SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'penyediaan-pengedalian-kes-srs' ? 'active' : null }}"><a href="{{route('rt-sm17.penyediaan_pengedalian_kes_srs')}}">Penyediaan Pengendalian Kes SRS</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-pengendalian-kes-srs' ? 'active' : null }}"><a href="{{route('rt-sm17.jana_laporan_pengendalian_kes_srs')}}">Jana Ringkasan Laporan Pengendalian Kes SRS</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-pengendalian-kes-srs-d' ? 'active' : null }}"><a href="{{route('rt-sm17.jana_laporan_pengendalian_kes_srs_d')}}">Jana Ringkasan Laporan Pengendalian Kes SRS Daerah</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-pengendalian-kes-srs-n' ? 'active' : null }}"><a href="{{route('rt-sm17.jana_laporan_pengendalian_kes_srs_n')}}">Jana Ringkasan Laporan Pengendalian Kes SRS Negeri</a></li>
                        <li class="{{ Request::segment(3) === 'jana-laporan-pengendalian-kes-srs-all' ? 'active' : null }}"><a href="{{route('rt-sm17.jana_laporan_pengendalian_kes_srs_all')}}">Jana Ringkasan Laporan Pengendalian Kes SRS Keseluruhan</a></li>
                        <li class="{{ Request::segment(3) === 'print-borang-masa-rehat' ? 'active' : null }}"><a href="{{route('rt-sm17.print_borang_masa_rehat')}}">Cetak Borang Permohonan Masa Rehat & Pelepasan Waktu Bekerja</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm18' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Penarikan Diri Ahli SRS</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-penarikan-diri-srs' ? 'active' : null }}"><a href="{{route('rt-sm18.permohonan_penarikan_diri_srs')}}">Permohonan Penarikan Diri SRS</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-penarikan-diri-srs' ? 'active' : null }}"><a href="{{route('rt-sm18.pengesahan_penarikan_diri_srs')}}">Pengesahan Penarikan Diri SRS</a></li>
                        <li class="{{ Request::segment(3) === 'kemaskini-aktif-maklumat-peronda' ? 'active' : null }}"><a href="{{route('rt-sm18.kemaskini_aktif_maklumat_peronda')}}">Kemaskini Keaktifan Maklumat Peronda</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm19' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span class="display-table">Pembatalan SRS</span></a>
                    <!-- <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-pembatalan-srs' ? 'active' : null }}"><a href="{{route('rt-sm19.permohonan_pembatalan_srs')}}">Permohonan Pembatalan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'semakan-permohonan-pembatalan-srs' ? 'active' : null }}"><a href="{{route('rt-sm19.semakan_permohonan_pembatalan_srs')}}">Semakan Permohonan Pembatalan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-permohonan-pembatalan-srs' ? 'active' : null }}"><a href="{{route('rt-sm19.pengesahan_permohonan_pembatalan_srs')}}">Pengesahan Permohonan Pembatalan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'jana-notis-pembatalan-srs' ? 'active' : null }}"><a href="{{route('rt-sm19.jana_notis_pembatalan_srs')}}">Jana Notis Pembatalan SRS</a></li>
                    </ul> -->
                </li>
                <li class="{{ Request::segment(2) === 'sm20' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>Laporan e-SRS</span></a>
                    <!-- <ul>
                        <li class="{{ Request::segment(3) === 'laporan-senarai-srs' ? 'active' : null }}"><a href="{{route('rt-sm20.laporan_senarai_srs')}}">Jana Laporan Senarai SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-pembatalan-srs' ? 'active' : null }}"><a href="{{route('rt-sm20.laporan_pembatalan_srs')}}">Jana Laporan Pembatalan SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-senarai-peronda-srs' ? 'active' : null }}"><a href="{{route('rt-sm20.laporan_senarai_peronda_srs')}}">Senarai Peronda SRS</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-ringkasan-jumlah-peronda-srs' ? 'active' : null }}"><a href="{{route('rt-sm20.laporan_ringkasan_jumlah_peronda_srs')}}">Ringkasan Jumlah Peronda SRS</a></li>
                    </ul> -->
                </li>
                <!-- <li class="{{ Request::segment(2) === 'sm21' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Kes</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-permohonan-insiden-admin' ? 'active' : null }}"><a href="{{route('rt-sm21.senarai_permohonan_insiden_admin')}}">Permohonan Pelaporan Kes</a></li>
                        <li class="{{ Request::segment(3) === 'akuan-permohonan-insiden-admin' ? 'active' : null }}"><a href="{{route('rt-sm21.akuan_permohonan_insiden_admin')}}">Memperakukan Permohonan Pelaporan Kes</a></li>
                        <li class="{{ Request::segment(3) === 'semakan-permohonan-insiden-admin' ? 'active' : null }}"><a href="{{route('rt-sm21.semakan_permohonan_insiden_admin')}}">Semakan Permohonan Pelaporan Kes</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-permohonan-insiden-admin' ? 'active' : null }}"><a href="{{route('rt-sm21.pengesahan_permohonan_insiden_admin')}}">Pengesahan Permohonan Pelaporan Kes</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm22' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Muhibbah</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-muhibbah-admin' ? 'active' : null }}"><a href="{{route('rt-sm22.permohonan_muhibbah_admin')}}">Permohonan Pelaporan Insiden</a></li>
                        <li class="{{ Request::segment(3) === 'memperakui-muhibbah-admin' ? 'active' : null }}"><a href="{{route('rt-sm22.memperakui_muhibbah_admin')}}">Memperakui Permohonan Pelaporan Insiden</a></li>
                        <li class="{{ Request::segment(3) === 'menyemak-muhibbah-admin' ? 'active' : null }}"><a href="{{route('rt-sm22.menyemak_muhibbah_admin')}}">Semakan Permohonan Pelaporan Insiden</a></li>
                        <li class="{{ Request::segment(3) === 'mengesahkan-muhibbah-admin' ? 'active' : null }}"><a href="{{route('rt-sm22.mengesahkan_muhibbah_admin')}}">Mengesahkan Permohonan Pelaporan Insiden</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm23' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>i-Mediator</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-mkp-admin' ? 'active' : null }}"><a href="{{route('rt-sm23.permohonan_mkp_admin')}}">Permohonan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'sokongan-mkp-admin-ppd' ? 'active' : null }}"><a href="{{route('rt-sm23.sokongan_mkp_admin_ppd')}}">Sokongan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'sokongan-mkp-admin-ppmk' ? 'active' : null }}"><a href="{{route('rt-sm23.sokongan_mkp_admin_ppmk')}}">Sokongan Pendaftaran MKP Pegawai</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-mkp-admin-ppn' ? 'active' : null }}"><a href="{{route('rt-sm23.pengesahan_mkp_admin_ppn')}}">Pengesahan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'menyemak-mkp-admin-hq' ? 'active' : null }}"><a href="{{route('rt-sm23.menyemak_mkp_admin_hq')}}">Menyemak Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'kelulusan-mkp-admin-hq' ? 'active' : null }}"><a href="{{route('rt-sm23.kelulusan_mkp_admin_hq')}}">Kelulusan Pendaftaran MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-mkp-admin' ? 'active' : null }}"><a href="{{route('rt-sm23.senarai_mkp_admin')}}">Senarai MKP</a></li>
                        <li class="{{ Request::segment(3) === 'statistik-mkp-admin' ? 'active' : null }}"><a href="{{route('rt-sm23.statistik_mkp_admin')}}">Statistik MKP</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm24' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>Penilaian Keaktifan MKP</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'borang-keaktifan-mkp-admin' ? 'active' : null }}"><a href="{{route('rt-sm24.borang_keaktifan_mkp_admin')}}">Borang Keaktifan MKP</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-keaktifan-mkp-admin' ? 'active' : null }}"><a href="{{route('rt-sm24.senarai_keaktifan_mkp_admin')}}">Laporan Penilaian Keaktifan MKP</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(2) === 'sm26' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>Pelaporan Mediasi</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'permohonan-laporan-kes-mediasi-admin' ? 'active' : null }}"><a href="{{route('rt-sm26.permohonan_laporan_kes_mediasi_admin')}}">Permohonan Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'perakuan-laporan-kes-mediasi-admin' ? 'active' : null }}"><a href="{{route('rt-sm26.perakuan_laporan_kes_mediasi_admin')}}">Perakuan Permohonan Laporan Kes Mediasi</a></li>
                        <li class="{{ Request::segment(3) === 'perakuan-laporan-kes-mediasi-admin-p' ? 'active' : null }}"><a href="{{route('rt-sm26.perakuan_laporan_kes_mediasi_admin_p')}}">Perakuan Permohonan Laporan Kes Mediasi (Pegawai)</a></li>
                        <li class="{{ Request::segment(3) === 'pengesahan-laporan-kes-mediasi-admin' ? 'active' : null }}"><a href="{{route('rt-sm26.pengesahan_laporan_kes_mediasi_admin')}}">Pengesahan Permohonan Laporan Kes Mediasi</a></li>
                    </ul>
                </li> -->
                <li class="{{ Request::segment(2) === 'sm27' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-star"></i><span>e-TP</span></a>
                    <ul>
                        <li class="{{ Request::segment(3) === 'senarai-mohon-masuk-tabika-admin' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_mohon_masuk_tabika_admin')}}">Permohonan Kemasukan Tabika Perpaduan</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-sah-mohon-masuk-tabika-admin' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_sah_mohon_masuk_tabika_admin')}}">Pengesahan Permohonan Kemasukan Tabika Perpaduan</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-lulus-mohon-masuk-tabika-admin' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_lulus_mohon_masuk_tabika_admin')}}">Kelulusan Permohonan Kemasukan Tabika Perpaduan</a></li>
                        <li class="{{ Request::segment(3) === 'senarai-masuk-tabika-admin' ? 'active' : null }}"><a href="{{route('rt-sm27.senarai_masuk_tabika_admin')}}">Senarai Kemasukan Tabika Perpaduan</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-bil-murid-negeri-admin' ? 'active' : null }}"><a href="{{route('rt-sm27.laporan_bil_murid_negeri_admin')}}">Laporan Bilangan Murid TP Ikut Negeri</a></li>
                        <li class="{{ Request::segment(3) === 'laporan-bil-murid-kaum-admin' ? 'active' : null }}"><a href="{{route('rt-sm27.laporan_bil_murid_kaum_admin')}}">Laporan Bilangan Murid TP Ikut Kaum</a></li>
                    </ul>
                </li>
                <li class="{{ Request::segment(1) === 'pengurusan' ? 'active' : null }}">
                    <a href="javascript:void(0)" class="has-arrow arrow-c"><i class="icon-wrench"></i><span>Modul Utiliti</span></a>
                    <ul>
                        <li class="{{ Request::segment(2) === 'pengguna' ? 'active' : null }}"><a href="{{route('pengurusan.pengguna')}}">Pengurusan Pengguna</a></li>
                        <li class="{{ Request::segment(2) === 'peranan' ? 'active' : null }}"><a href="{{route('pengurusan.peranan')}}">Pengurusan Peranan</a></li>
                        <li class="{{ Request::segment(2) === 'rujukan-data' ? 'active' : null }}"><a href="{{route('pengurusan.rujukan_data')}}">Pengurusan Rujukan Data </a></li>
                        <!-- <li class="{{ Request::segment(2) === 'audit-trail' ? 'active' : null }}"><a href="{{route('pengurusan.audit_trail')}}">Audit Trail</a></li> -->
                        <!-- <li class="{{ Request::segment(2) === 'rujukan-emel' ? 'active' : null }}"><a href="{{route('pengurusan.rujukan_emel')}}">Rujukan Emel</a></li> -->
                    </ul>
                </li>
                @endauth
            @endif
        </ul>
    </nav>        
</div>