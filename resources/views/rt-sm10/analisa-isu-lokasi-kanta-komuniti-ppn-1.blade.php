@extends('layout.master')
@section('title', 'Isu Dan Masalah Di Lokasi Kanta Komuniti')


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
                                                        <p><span style="font-size:12px">Nama Kawasan Rukun Tetangga (KRT)</span><br><b><span id="silkk_nama_krt" name="silkk_nama_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Alamat Kawasan Rukun Tetangga (KRT)</span><br><b><span id="silkk_alamat_krt" name="silkk_alamat_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Negeri</span><br><b><span id="silkk_negeri_krt" name="silkk_negeri_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Parlimen</span><br><b><span id="silkk_parlimen_krt" name="silkk_parlimen_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Pihak Berkuasa Tempatan</span><br><b><span id="silkk_pbt_krt" name="silkk_pbt_krt"></span></b></p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <p><span style="font-size:12px">Daerah</span><br><b><span id="silkk_daerah_krt" name="silkk_daerah_krt"></span></b></p>
                                                        <p><span style="font-size:12px">Dun</span><br><b><span id="silkk_dun_krt" name="silkk_dun_krt"></span></b></p>
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
                                                <div class="row clearfix">
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Lokasi Kanta Komuniti: </label>
                                                            <input type="text" class="form-control" name="silkk_isu_lokasi_kanta_komuniti" id="silkk_isu_lokasi_kanta_komuniti" placeholder="Lokasi Kanta Komuniti" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Bilangan Yang Terlibat: </label>
                                                            <input type="text" class="form-control" name="silkk1_isu_bil_terlibat" id="silkk1_isu_bil_terlibat" placeholder="Bilangan Yang Terlibat" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <div class="form-group">
                                                            <label class="form-label">Kluster Isu Dan Masalah: </label>
                                                            <input type="text" class="form-control" name="silkk1_isu_kluster" id="silkk1_isu_kluster" placeholder="Kluster Isu Dan Masalah" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Bilangan Yang Terlibat Mengikut Kaum : </label>
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table class="table thead-dark table-bordered table-striped" id="senarai_terlibat_table" style="width: 100%" border="1">
                                                                <thead>
                                                                    <tr>
                                                                        <th><label class="form-label"><font color="#113f50">Bil</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Bilangan</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Kaum</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Jantina</font></label></th>
                                                                        <th><label class="form-label"><font color="#113f50">Umur</font></label></th>
                                                                    </tr>
                                                                </thead>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="row clearfix">
                                                    <div class="form-group">
                                                        <label class="form-label">Tindakan Penyelesaian Oleh : </label>
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                        <div class="form-group">
                                                            <label class="form-label">i) Jawatankuasa Pelaksana Kanta Komuniti Peringkat Daerah: </label>
                                                            <textarea class="form-control" rows="4" name="silkk3_isu_pelaksanan_daerah" id="silkk3_isu_pelaksanan_daerah" placeholder="Jawatankuasa Pelaksana Kanta Komuniti Peringkat Daerah" disabled></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">ii) Jawatankuasa Pelaksana Kanta Komuniti Peringkat Negeri: </label>
                                                            <textarea class="form-control" rows="4" name="silkk3_isu_pelaksanan_negeri" id="silkk3_isu_pelaksanan_negeri" placeholder="Jawatankuasa Pelaksana Kanta Komuniti Peringkat Negeri" disabled></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Agensi Yang Terlibat: </label>
                                                            <input type="text" class="form-control" name="silkk3_isu_agensi_terlibat" id="silkk3_isu_agensi_terlibat" placeholder="Agensi Yang Terlibat" disabled>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-label">Status Isu / Masalah: </label>
                                                            <div class="custom-controls-stacked">
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="silkk3_isu_status" value="1" disabled>
                                                                    <span class="custom-control-label">Selesai</span>
                                                                </label><br>
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="silkk3_isu_status" value="2" disabled>
                                                                    <span class="custom-control-label">Belum Selesai Sepenuhnya</span>
                                                                </label><br>
                                                                <label class="custom-control custom-radio custom-control-inline">
                                                                    <input type="radio" class="custom-control-input" name="silkk3_isu_status" value="3" disabled>
                                                                    <span class="custom-control-label">Belum Selesai</span>
                                                                </label><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="btn_back"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                            <button type="button" class="btn btn-secondary" disabled>Seterusnya&nbsp;&nbsp;<i class="dropdown-icon fe fe-arrow-right"></i></button>
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

@include('js.rt-sm10.j-analisa-isu-lokasi-kanta-komuniti-ppn-1')
