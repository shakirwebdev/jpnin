@extends('layout.master')
@section('title', 'Borang Permohonan Pembatalan Skim Rondaan Sukarela (SRS)')


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
                    <div class="tab-content mt-3">
                        <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                            <div class="mb-10">
                                <code><span style="text-size: 16px;"><strong>No Rujukan Permohonan Pembatalan SRS: </strong></span></code>
                                <br>
                                <br>
                                Permohonan Pembatalan Skim Rondaan Sukarela (SRS) sedang dalam proses tindakan dan pengesahan oleh pihak Pengarah Perpaduan Negeri (PPN) dan Pegawai Perpaduan Daerah (PPD). 
                                <br>
                                <br>
                                Sepanjang proses pengesahan ini, maklumat yang dibekalkan di-'kunci' untuk seketika. Untuk membuat perubahan, sila tekan butang "Permohonan Mengubah Kandungan" dibawah dan sebahagian dari maklumat 
                                sahaja dibenarkan perubahan dibuat.
                                <br>
                            </div>
                            <form method="POST" action="{{ route('rt-sm1.unlock_permohonan_penubuhan_krt') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-xs mb-2">Permohonan Mengubah Kandungan</button>
                            <!-- <button type="button" class="btn btn-secondary btn-xs mb-2" onclick="window.location.href = '{{route('rt-sm1.status_permohonan_penubuhan_krt')}}';">Semak Permohonan</button> -->
                            </form>
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
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT SKIM RONDAAN SUKARELA</b></h6>
                                                <br>
                                                <p><span style="font-size:12px">No Pendaftaran SRS</span><br><b>SRS/00001</b></p>
                                                <p><span style="font-size:12px">Nama Skim Rondaan Sukarela (SRS)</span><br><b>SRS Taman Peladang Jaya</b></p>
                                                <p><span style="font-size:12px">Nama Kawasn Rukun Tetangga (KRT)</span><br><b>KRT Taman Peladang Jaya</b></p>
                                                <p><span style="font-size:12px">Negeri</span><br><b>Perlis</b></p>
                                                <p><span style="font-size:12px">Daerah</span><br><b>Kangar</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <h6><b>MAKLUMAT PEMOHON</b></h6>
                                                <br><br>
                                                <div class="form-group">
                                                    <label class="form-label">Nama Pemohon: </label>
                                                    <input type="text" class="form-control" name="" placeholder="Nama Pemohon" value="Mohamad Shauki Bin Sahardi" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">No Kad Pengenalan: </label>
                                                    <input type="text" class="form-control" name="" placeholder="No Kad Pengenalan" value="930508-09-5161" disabled="">
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">Alamat: </label>
                                                    <textarea class="form-control" id="" name="" rows="4" disabled="">
No, 10 Lorong 5,
Taman Peladang Jaya,
02000 Kuala Perlis, Perlis
                                                    </textarea>
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
                                            <h6><b>MAKLUMAT SENARAI DOKUMEN DIPERLUKAN</b></h6>
                                            <br>
                                            <p>1. Peringkat Pemohon : <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <br/>
                                                            <label class="form-label">Tajuk: </label>
                                                            <select class="select2 custom-select" id="nama_krt" name="nama_krt">
                                                                <option value="">-- Pilih Nama --</option>
                                                                <option value="">Minit Mesyuarat Pembatalan Rukun Tetangga</option>
                                                                <option value="">Penyata Akaun Terbaru</option>
                                                                <option value="">Salinan Buku Daftar</option>
                                                                <option value="">Buku Stok Tetangga</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Catatan : </label>
                                                            <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">File : </label>
                                                            <input type="file" class="dropify">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        <br/><br/><br/>
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_dokument_pemohon_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Tajuk</font></label></th>
                                                                <th width="30%"><label class="form-label"><font color="#113f50">Catatan</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">File</font></label></th>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <p>2. Peringkat PPD / PPB : <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <br/>
                                                            <label class="form-label">Tajuk: </label>
                                                            <select class="select2 custom-select" id="nama_krt" name="nama_krt">
                                                                <option value="">-- Pilih Nama --</option>
                                                                <option value="">Minit Mesyuarat Pembatalan Rukun Tetangga</option>
                                                                <option value="">Penyata Akaun Terbaru</option>
                                                                <option value="">Salinan Buku Daftar</option>
                                                                <option value="">Buku Stok Tetangga</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Catatan : </label>
                                                            <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">File : </label>
                                                            <input type="file" class="dropify">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        <br/><br/><br/>
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_dokument_ppd_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Tajuk</font></label></th>
                                                                <th width="30%"><label class="form-label"><font color="#113f50">Catatan</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">File</font></label></th>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <p>3. Peringkat PPN : <span class="text-red">*</span></p>
                                            <hr class="mt-1">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="series-frame">
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <br/>
                                                            <label class="form-label">Tajuk: </label>
                                                            <select class="select2 custom-select" id="nama_krt" name="nama_krt">
                                                                <option value="">-- Pilih Nama --</option>
                                                                <option value="">Minit Mesyuarat Pembatalan Rukun Tetangga</option>
                                                                <option value="">Penyata Akaun Terbaru</option>
                                                                <option value="">Salinan Buku Daftar</option>
                                                                <option value="">Buku Stok Tetangga</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Catatan : </label>
                                                            <textarea class="form-control" id="" name="" rows="4"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">File : </label>
                                                            <input type="file" class="dropify">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary pull-right"><i class="fe fe-plus mr-2"></i>Tambah</button>
                                                        <br/><br/><br/>
                                                    </div>
                                                </div>
                                                <br/><br/>
                                                <div class="table-responsive">
                                                    <table class="table thead-dark table-bordered table-striped" id="senarai_dokument_ppn_table" style="width: 100%" border="1">
                                                        <thead>
                                                            <tr>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">Tajuk</font></label></th>
                                                                <th width="30%"><label class="form-label"><font color="#113f50">Catatan</font></label></th>
                                                                <th><label class="form-label"><font color="#113f50">File</font></label></th>
                                                                <th width="10%"><label class="form-label"><font color="#113f50">Tindakan</font></label></th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" onclick="window.location.href = '{{route('rt-sm8.permohonan_pembatalan_krt')}}';"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="submit" class="btn btn-primary">Hantar Permohonan Pembatalan SRS&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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

@include('js.rt-sm19.j-borang-pembatalan-srs')
