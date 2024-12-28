@extends('layout.master')
@section('title', 'Tambah Penyediaan Pelaksanaan Rondaan SRS')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pprs2_nama_krt" name="pprs2_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="pprs2_alamat_krt" name="pprs2_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="pprs2_negeri_krt" name="pprs2_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="pprs2_parlimen_krt" name="pprs2_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="pprs2_pbt_krt" name="pprs2_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="pprs2_daerah_krt" name="pprs2_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="pprs2_dun_krt" name="pprs2_dun_krt"></span></b></p>
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
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <h6><b>MAKLUMAT KES</b></h6>
                                                <br>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form action="#" id="form_pprs2" >
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Kategori Kes: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pprs2_kategori_id" id="pprs2_kategori_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($kategori_kes as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->kategori_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pprs2_kategori_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Jenis Kes: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pprs2_jenis_id" id="pprs2_jenis_id" disabled>
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($jenis_kes as $item)                                    
                                                                        <option value="{{ $item->id}}">{{ $item->jenis_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pprs2_jenis_id invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Keterangan Kes: <label><font color="red">*</font></label> </label>
                                                                <textarea id="pprs2_kes_keterangan" name="pprs2_kes_keterangan" class="form-control"></textarea>
                                                                <div class="error_pprs2_kes_keterangan invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </form>
                                                <form action="#" id="form_pprs3" >
                                                {{ csrf_field() }}
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Yang Terlibat Mengikut Kaum: <span class="text-red">*</span></label>
                                                            </div>
                                                            <div class="col-md-12 alert alert-danger error_form_pprs3" role="alert" style="display: none; padding-bottom: 0px;">
                                                                <ul></ul>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Kaum: </label>
                                                                        <select class="form-control" name="pprs3_kaum_id" id="pprs3_kaum_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($kaum as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->kaum_description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div> 
                                                                    <div class="form-group">
                                                                        <label class="form-label">Bilangan: </label>
                                                                        <input type="text" class="form-control" name="pprs3_terlibat_bilangan" id="pprs3_terlibat_bilangan" placeholder="Bilangan">
                                                                    </div><br><br>
                                                                </div>
                                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Jantina: </label>
                                                                        <select class="form-control" name="pprs3_jantina_id" id="pprs3_jantina_id">
                                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                            @foreach($jantina as $item)                                    
                                                                                <option value="{{ $item->id }}">{{ $item->jantina_description }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">Umur: </label>
                                                                        <input type="text" class="form-control" name="pprs3_terlibat_umur" id="pprs3_terlibat_umur" placeholder="Umur">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="add_kaum_terlibat" value="add">
                                                                        <input type="hidden" name="pprs3_srs_pelaksanaan_rondaan_id" id="pprs3_srs_pelaksanaan_rondaan_id" >
                                                                        <button type="submit" class="btn btn-primary pull-right" id="btn_add_kaum_terlibat"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br/><br/>
                                                            <div class="table-responsive">
                                                                <table class="table thead-dark table-bordered table-striped" id="senarai_terlibat_table" style="width: 100%" border="1">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                            <th width="30%"><label class="form-label"><font color="#113f50">Bilangan</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Jantina</font></label></th>
                                                                            <th><label class="form-label"><font color="#113f50">Umur</font></label></th>
                                                                            <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                                        </tr>
                                                                    </thead>
                                                                </table>
                                                                <br><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <form action="#" id="form_pprs4" >
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Bilangan Orang Yang Terlibat: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="pprs4_kes_jumlah_org_terlibat" id="pprs4_kes_jumlah_org_terlibat" placeholder="Bilangan Orang">
                                                                <div class="error_pprs4_kes_jumlah_org_terlibat invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Kes dirujuk kepada: <span class="text-red">*</span></label>
                                                                <select class="form-control" name="pprs4_kes_dirujuk_id" id="pprs4_kes_dirujuk_id">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($rujuk_kes as $item)                                    
                                                                        <option value="{{ $item->id}}">{{ $item->rujuk_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_pprs4_kes_dirujuk_id invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form method="POST" id="form_pprs5">
                                                @csrf
                                                    <input type="hidden" name="pprs5_srs_pelaksanaan_rondaan_id" id="pprs5_srs_pelaksanaan_rondaan_id" >
                                                    <input type="hidden" name="action" id="post_tambah_pelaksanaan_rondaan_3" value="edit">
                                                    <input type="hidden" name="post_tambah_pelaksanaan_rondaan_3" value="edit">
                                                    <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                    <button type="submit" class="btn btn-primary" id="btn_submit">Hantar Pelaksanaan Rondaan SRS&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="../assets/plugins/datatable/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
<link rel="stylesheet" href="../assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
@stop

@include('js.rt-sm16.j-penyediaan-pelaksanaan-rondaan-srs-2')
