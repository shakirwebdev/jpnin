@extends('layout.master')
@section('title', 'MEMPERAKUI PERANCANGAN AKTIVTI DAN PERKHIDMATAN SEJIWA')


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
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Carian</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <label>Tahun</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="">
                                                <option value="">-- Sila Pilih --</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <label>Negeri</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="">
                                                <option value="">-- Sila Pilih --</option>
                                                <option value="">JOHOR</option>
                                                <option value="">KEDAH</option>
                                                <option value="">KELANTAN</option>
                                                <option value="">MELAKA</option>
                                                <option value="">NEGERI SEMBILAN</option>
                                                <option value="">PAHANG</option>
                                                <option value="">PULAU PINANG</option>
                                                <option value="">PERAK</option>
                                                <option value="">PERLIS</option>
                                                <option value="">SELANGOR</option>
                                                <option value="">TERENGGANU</option>
                                                <option value="">SABAH</option>
                                                <option value="">SARAWAK</option>
                                                <option value="">W.P KUALA LUMPUR</option>
                                                <option value="">W.P LABUAN</option>
                                                <option value="">W.P PUTRAJAYA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <label>Daerah</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="">
                                                <option value="">-- Sila Pilih --</option>
                                                <option value="">BATU PAHAT</option>
                                                <option value="">JOHOR BAHRU</option>
                                                <option value="">KLUANG</option>
                                                <option value="">KOTA TINGGI</option>
                                                <option value="">MERSING</option>
                                                <option value="">MUAR</option>
                                                <option value="">PONTIAN</option>
                                                <option value="">SEGAMAT</option>
                                                <option value="">KULAI</option>
                                                <option value="">TANGKAK</option>
                                                <option value="">KOTA SETAR</option>
                                                <option value="">KUBANG PASU</option>
                                                <option value="">PADANG TERAP</option>
                                                <option value="">LANGKAWI</option>
                                                <option value="">KUALA MUDA</option>
                                                <option value="">YAN</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <label>&nbsp;</label>
                                        <br>
                                         <form>
                                            <div class="input-group">
                                                <span class="input-group-btn ml-2"><button class="btn btn-icon" type="submit"><span class="fe fe-search"></span></button></span>
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
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Senarai SeJIWA</h3>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="senari_ahli_cawangan" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Bil</th>
                                                    <th>Negeri</th>
                                                    <th>Daerah</th>
                                                    <th>Tahun</th>
                                                    <th width="20%">Nama SeJIWA</th>
                                                    <th>Tarikh Penubuhan Skuad</th>
                                                    <th>Pegawai Rujukan / Penyelia Sejiwa</th>
                                                    <th>Status</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                        </table>
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
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
@stop

@include('js.rt-sm10.j-memperakui-perancangan-aktivti-sejiwa')
