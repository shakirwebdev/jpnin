@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Kemaskini Rekod Penerimaan & Pengeluaran Kewangan')


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
    <div class="section-body mt-3" style="display:none;" id="krkr_perlu_kemaskini">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert" >
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> 
                                <span class="text-red blink" id="krkr_status_description" name="krkr_status_description"></span></b>
                                <br><br>
                                <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> 
                                <span id="krkr_semak_note" name="krkr_semak_note"></span></span>
                                <span id="krkr_sah_note" name="krkr_sah_note"></span></span>.
                                <br>
                                <input type="hidden" name="krkr_status" id="krkr_status">
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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="krkr_nama_krt" name="krkr_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="krkr_alamat_krt" name="krkr_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="krkr_negeri_krt" name="krkr_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="krkr_parlimen_krt" name="krkr_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="krkr_pbt_krt" name="krkr_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="krkr_daerah_krt" name="krkr_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="krkr_dun_krt" name="krkr_dun_krt"></span></b></p>
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
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <form action="#" id="form_krkr" >
                                                @csrf
                                                    <div class="row clearfix">
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <h6><b>MAKLUMAT KEWANGAN RUKUN TETANGGA</b></h6>
                                                            <br>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Jenis Kewangan: </label>
                                                                <select class="form-control" name="krkr_kewangan_jenis_kewangan" id="krkr_kewangan_jenis_kewangan">
                                                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                                    @foreach($ref_jenis_kewangan as $item)                                    
                                                                        <option value="{{ $item->id }}">{{ $item->jenis_kewangan_description }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="error_krkr_kewangan_jenis_kewangan invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Bank: </label>
                                                                <input type="text" class="form-control" name="krkr_kewangan_nama_bank" id="krkr_kewangan_nama_bank" placeholder="Nama Bank" disabled>
                                                                <div class="error_krkr_kewangan_nama_bank invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No Akaun: </label>
                                                                <input type="text" class="form-control" name="krkr_kewangan_no_acc" id="krkr_kewangan_no_acc" placeholder="No Akaun" disabled>
                                                                <div class="error_krkr_kewangan_no_acc invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">No E-Vendor: </label>
                                                                <input type="text" class="form-control" name="krkr_kewangan_no_evendor" id="krkr_kewangan_no_evendor" placeholder="No E-Vendor" disabled>
                                                                <div class="error_krkr_kewangan_no_evendor invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                                            <div class="form-group">
                                                                <label class="form-label">Nama Penuh: </label>
                                                                <input type="text" class="form-control" name="krkr_kewangan_nama_penuh" id="krkr_kewangan_nama_penuh" placeholder="Nama Penuh">
                                                                <div class="error_krkr_kewangan_nama_penuh invalid-feedback text-right"></div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Alamat: </label>
                                                                <textarea class="form-control" name="krkr_kewangan_alamat" id="krkr_kewangan_alamat" rows="6" placeholder="Alamat"></textarea>
                                                                <div class="error_krkr_kewangan_alamat invalid-feedback text-right"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Maklumat Kewangan: </label>
                                                            </div>
                                                            <div class="series-frame">
                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label">Butiran:</label>
                                                                        <input type="text" class="form-control" name="krkr_kewangan_butiran" id="krkr_kewangan_butiran" placeholder="Butiran">
                                                                        <div class="error_krkr_kewangan_butiran invalid-feedback text-right"></div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <b>Tarikh Penerimaan / Pembayaran</b>
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="krkr_kewangan_tarikh_t_b" id="krkr_kewangan_tarikh_t_b" placeholder="Tarikh Penerimaan / Pembayaran">
                                                                            <div class="error_krkr_kewangan_tarikh_t_b invalid-feedback text-right"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label class="form-label">No Cek / No Baucer:</label>
                                                                        <input type="text" class="form-control" name="krkr_kewangan_cek_baucer" id="krkr_kewangan_cek_baucer" placeholder="No Cek / No Baucer">
                                                                        <div class="error_krkr_kewangan_cek_baucer invalid-feedback text-right"></div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <b>Tarikh Cek / Tarikh Baucer</b>
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="krkr_kewangan_tarikh_cek" id="krkr_kewangan_tarikh_cek" placeholder="Tarikh Cek / Tarikh Baucer">
                                                                            <div class="error_krkr_kewangan_tarikh_cek invalid-feedback text-right"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <b>Jumlah</b>
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Tunai (RM)</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="krkr_kewangan_jumlah_tunai" id="krkr_kewangan_jumlah_tunai" placeholder="Tunai">
                                                                            <div class="error_krkr_kewangan_jumlah_tunai invalid-feedback text-right"></div>
                                                                        </div>
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Bank (RM)</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="krkr_kewangan_jumlah_bank" id="krkr_kewangan_jumlah_bank" placeholder="Bank">
                                                                            <div class="error_krkr_kewangan_jumlah_bank invalid-feedback text-right"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <b>Baki</b>
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Tunai (RM)</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="kewangan_baki_tunai" id="kewangan_baki_tunai" placeholder="Tunai" disabled>
                                                                            <input type="hidden" name="krkr_kewangan_baki_tunai" id="krkr_kewangan_baki_tunai" >
                                                                        </div>
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Bank (RM)</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="kewangan_baki_bank" id="kewangan_baki_bank" placeholder="Bank" disabled>
                                                                            <input type="hidden" name="krkr_kewangan_baki_bank" id="krkr_kewangan_baki_bank" >
                                                                        </div>
                                                                        <div class="input-group mb-3">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">Jumlah (RM)</span>
                                                                            </div>
                                                                            <input type="text" class="form-control" name="kewangan_jumlah_baki" id="kewangan_jumlah_baki" placeholder="Jumlah" disabled>
                                                                            <input type="hidden" name="krkr_kewangan_jumlah_baki" id="krkr_kewangan_jumlah_baki" >
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                                            <br>
                                                            <input type="hidden" name="krkr_krt_kewangan_id" id="krkr_krt_kewangan_id" >
                                                            <input type="hidden" name="post_edit_rekod_kewangan_rt" value="edit">
                                                            <input type="hidden" name="action" id="post_edit_rekod_kewangan_rt" value="edit">
                                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
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
        </div>            
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm7.j-kemaskini-rekod-kewangan-rt-1')