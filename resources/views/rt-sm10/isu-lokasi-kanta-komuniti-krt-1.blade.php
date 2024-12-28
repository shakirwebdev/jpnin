@extends('layout.master')
@section('title', 'Permohonan Isu Dan Masalah Di Lokasi Kanta Komuniti')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang HANTAR. 
                        <br>
                        Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3" style="display:none;" id="ilkk_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span class="text-red blink" id="ilkk_status_description" name="ilkk_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="ilkk_disemak_note" name="ilkk_disemak_note"></span><span id="ilkk_disahkan_note" name="ilkk_disahkan_note"></span>.
                                <br>
                                <input type="hidden" name="ilkk_status" id="ilkk_status">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="row clearfix">
                            <div class="col-lg-4 col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <h6><b>MAKLUMAT KAWASAN RUKUN TETANGGA</b></h6>
                                                    <br><br>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ilkk_nama_krt" name="ilkk_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="ilkk_alamat_krt" name="ilkk_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="ilkk_negeri_krt" name="ilkk_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="ilkk_parlimen_krt" name="ilkk_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="ilkk_pbt_krt" name="ilkk_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="ilkk_daerah_krt" name="ilkk_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="ilkk_dun_krt" name="ilkk_dun_krt"></span></b></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6><b>MAKLUMAT ISU DAN MASALAH DI LOKASI KANTA KOMUNITI</b></h6>
                                            <br>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_ilkk1">
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Lokasi Kanta Komuniti: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ilkk1_isu_lokasi_kanta_komuniti" id="ilkk1_isu_lokasi_kanta_komuniti" placeholder="Lokasi Kanta Komuniti" >
                                                                <div class="error_ilkk1_isu_lokasi_kanta_komuniti invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Yang Terlibat: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ilkk1_isu_bil_terlibat" id="ilkk1_isu_bil_terlibat" placeholder="Bilangan Yang Terlibat" >
                                                                <div class="error_ilkk1_isu_bil_terlibat invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Kluster Isu Dan Masalah: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ilkk1_isu_kluster" id="ilkk1_isu_kluster" placeholder="Kluster Isu Dan Masalah" >
                                                                <div class="error_ilkk1_isu_kluster invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form action="#" id="form_ilkk2">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label class="form-label">Bilangan Yang Terlibat Mengikut Kaum : </label>
                                                    </div>
                                                    <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                                                        <ul></ul>
                                                    </div>
                                                    <div class="series-frame">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ilkk2_bilangan" id="ilkk2_bilangan" placeholder="Bilangan">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Kaum: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ilkk2_kaum_id" id="ilkk2_kaum_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($ref_kaum as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jantina: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="ilkk2_jantina_id" id="ilkk2_jantina_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($ref_jantina as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Umur: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ilkk2_umur" id="ilkk2_umur" placeholder="Umur">
                                                            </div>
                                                            <input type="hidden" name="ilkk2_isu_lokasi_kk_id" id="ilkk2_isu_lokasi_kk_id">
                                                            <input type="hidden" name="add_isu_lokasi_kk_terlibat" value="add">
                                                            <button type="submit" class="btn btn-primary pull-right" id="btn_save_bil_kaum"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        </div>
                                                    </div>
                                                    <br/><br/>
                                                    <div class="table-responsive">
                                                        <table class="table thead-dark table-bordered table-striped" id="senarai_terlibat_table" style="width: 100%" border="1">
                                                            <thead>
                                                                <tr>
                                                                    <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Bilangan</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Jantina</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Umur</font></label></th>
                                                                    <th><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_ilkk3">
                                                    @csrf
                                                    <div class="row clearfix">
                                                        <div class="form-group">
                                                            <label class="form-label">Tindakan Penyelesaian Oleh : </label>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">i) Jawatankuasa Pelaksana Kanta Komuniti Peringkat Daerah: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="4" name="ilkk3_isu_pelaksanan_daerah" id="ilkk3_isu_pelaksanan_daerah" placeholder="Jawatankuasa Pelaksana Kanta Komuniti Peringkat Daerah"></textarea>
                                                                <div class="error_ilkk3_isu_pelaksanan_daerah invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">ii) Jawatankuasa Pelaksana Kanta Komuniti Peringkat Negeri: <span class="text-red">*</span></label>
                                                                <textarea class="form-control" rows="4" name="ilkk3_isu_pelaksanan_negeri" id="ilkk3_isu_pelaksanan_negeri" placeholder="Jawatankuasa Pelaksana Kanta Komuniti Peringkat Negeri"></textarea>
                                                                <div class="error_ilkk3_isu_pelaksanan_negeri invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Agensi Yang Terlibat: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="ilkk3_isu_agensi_terlibat" id="ilkk3_isu_agensi_terlibat" placeholder="Agensi Yang Terlibat">
                                                                <div class="error_ilkk3_isu_agensi_terlibat invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Status Isu / Masalah: <span class="text-red">*</span></label>
                                                                <div class="custom-controls-stacked">
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="ilkk3_isu_status" value="1">
                                                                        <span class="custom-control-label">Selesai</span>
                                                                    </label><br>
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="ilkk3_isu_status" value="2">
                                                                        <span class="custom-control-label">Belum Selesai Sepenuhnya</span>
                                                                    </label><br>
                                                                    <label class="custom-control custom-radio custom-control-inline">
                                                                        <input type="radio" class="custom-control-input" name="ilkk3_isu_status" value="3">
                                                                        <span class="custom-control-label">Belum Selesai</span>
                                                                    </label><br>
                                                                </div>
                                                                <div class="error_ilkk3_isu_status invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <form method="POST" id="form_ilkk4">
                                            @csrf
                                                <input type="hidden" name="ilkk4_isu_lokasi_kk_id" id="ilkk4_isu_lokasi_kk_id">
                                                <input type="hidden" name="action" id="post_lapor_isu_lokasi_kanta_komuniti_1" value="edit">
                                                <input type="hidden" name="post_lapor_isu_lokasi_kanta_komuniti_1" value="edit">
                                                <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Lapor Isu Dan Masalah Lokasi Kanta Komuniti &nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm10.j-isu-lokasi-kanta-komuniti-krt-1')
