@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Rekod Penerimaan & Pengeluaran Kewangan')


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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="arkr_nama_krt" name="arkr_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="arkr_alamat_krt" name="arkr_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="arkr_negeri_krt" name="arkr_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="arkr_parlimen_krt" name="arkr_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="arkr_pbt_krt" name="arkr_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="arkr_daerah_krt" name="arkr_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="arkr_dun_krt" name="arkr_dun_krt"></span></b></p>
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
                                        <form action="#" id="form_arkr" >
                                        @csrf
                                            <div class="row clearfix">
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <h6><b>MAKLUMAT KEWANGAN RUKUN TETANGGA</b></h6>
                                                    <br>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Jenis Kewangan: <span class="text-red">*</span></label>
                                                        <select class="form-control" name="arkr_kewangan_jenis_kewangan" id="arkr_kewangan_jenis_kewangan">
                                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                            @foreach($ref_jenis_kewangan as $item)                                    
                                                                <option value="{{ $item->id }}">{{ $item->jenis_kewangan_description }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="error_arkr_kewangan_jenis_kewangan invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Bank: </label>
                                                        <input type="text" class="form-control" name="arkr_kewangan_nama_bank" id="arkr_kewangan_nama_bank" placeholder="Nama Bank" disabled>
                                                        <div class="error_arkr_kewangan_nama_bank invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No Akaun: </label>
                                                        <input type="text" class="form-control" name="arkr_kewangan_no_acc" id="arkr_kewangan_no_acc" placeholder="No Akaun" disabled>
                                                        <div class="error_arkr_kewangan_no_acc invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">No E-Vendor: </label>
                                                        <input type="text" class="form-control" name="arkr_kewangan_no_evendor" id="arkr_kewangan_no_evendor" placeholder="No E-Vendor" disabled>
                                                        <div class="error_arkr_kewangan_no_evendor invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6">
                                                    <p>Pihak Yang Membuat Bayaran kepada KRT / Pihak Yang terima Bayaran Daripada KRT</p>
                                                    <hr class="mt-1">
                                                    <div class="form-group">
                                                        <label class="form-label">Nama Penuh: <span class="text-red">*</span></label>
                                                        <input type="text" class="form-control" name="arkr_kewangan_nama_penuh" id="arkr_kewangan_nama_penuh" placeholder="Nama Penuh">
                                                        <div class="error_arkr_kewangan_nama_penuh invalid-feedback text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">Alamat: <span class="text-red">*</span></label>
                                                        <textarea class="form-control" name="arkr_kewangan_alamat" id="arkr_kewangan_alamat" rows="6" placeholder="Alamat"></textarea>
                                                        <div class="error_arkr_kewangan_alamat invalid-feedback text-right"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Maklumat Kewangan: </label>
                                                    </div>
                                                    <div class="series-frame">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Butiran: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="arkr_kewangan_butiran" id="arkr_kewangan_butiran" placeholder="Butiran">
                                                                <div class="error_arkr_kewangan_butiran invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Tarikh Penerimaan / Pembayaran: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="arkr_kewangan_tarikh_t_b" id="arkr_kewangan_tarikh_t_b" placeholder="Tarikh Penerimaan / Pembayaran" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_arkr_kewangan_tarikh_t_b invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Cek / No Baucer: <span class="text-red">*</span></label>
                                                                <input type="text" class="form-control" name="arkr_kewangan_cek_baucer" id="arkr_kewangan_cek_baucer" placeholder="No Cek / No Baucer">
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Tarikh Cek / Tarikh Baucer: <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                    <input data-provide="datepicker" data-date-autoclose="true" class="form-control" name="arkr_kewangan_tarikh_cek" id="arkr_kewangan_tarikh_cek" placeholder="Tarikh Cek / Tarikh Baucer" data-date-format="dd/mm/yyyy">
                                                                    <div class="error_arkr_kewangan_tarikh_cek invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Jumlah <span class="text-red">*</span></b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Tunai (RM)</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="arkr_kewangan_jumlah_tunai" id="arkr_kewangan_jumlah_tunai" placeholder="cth : 0.00">
                                                                    <div class="error_arkr_kewangan_jumlah_tunai invalid-feedback text-right"></div>
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Bank (RM)</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="arkr_kewangan_jumlah_bank" id="arkr_kewangan_jumlah_bank" placeholder="cth : 0.00">
                                                                    <div class="error_arkr_kewangan_jumlah_bank invalid-feedback text-right"></div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <b>Baki</b>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Tunai (RM)</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="kewangan_baki_tunai" id="kewangan_baki_tunai" placeholder="Tunai" disabled>
                                                                    <input type="hidden" name="arkr_kewangan_baki_tunai" id="arkr_kewangan_baki_tunai" >
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Bank (RM)</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="kewangan_baki_bank" id="kewangan_baki_bank" placeholder="Bank" disabled>
                                                                    <input type="hidden" name="arkr_kewangan_baki_bank" id="arkr_kewangan_baki_bank" >
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Jumlah (RM)</span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="kewangan_jumlah_baki" id="kewangan_jumlah_baki" placeholder="Jumlah" disabled>
                                                                    <input type="hidden" name="arkr_kewangan_jumlah_baki" id="arkr_kewangan_jumlah_baki" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                    <br/>
                                                    <input type="hidden" name="arkr_krt_profile_id" id="arkr_krt_profile_id" >
                                                    <input type="hidden" name="post_rekod_kewangan_rt" value="add">
                                                    <input type="hidden" name="action" id="post_rekod_kewangan_rt" value="add">
                                                    <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm7.senarai_rekod_kewangan_rt')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                                    <button type="submit" class="btn btn-primary" id="btn_send">Hantar Maklumat Kewangan&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
                                                </div>
                                            </div>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@stop

@include('js.rt-sm7.j-add-rekod-kewangan-rt')