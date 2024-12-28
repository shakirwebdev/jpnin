@extends('layout.master')
@section('title', 'Laporan Ahli Jawatankuasa Kawasan Rukun Tertangga')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Carian</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label class="form-label">Senarai Negeri</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lakhq_state_id" name="lakhq_state_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($state as $item)                                    
                                                <option value="{{ $item->state_description }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label class="form-label">Senarai Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lakhq_daerah_id" name="lakhq_daerah_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label class="form-label">Senarai Parlimen</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lakhq_parlimen_id" name="lakhq_parlimen_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label class="form-label">Senarai Dun</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lakhq_dun_id" name="lakhq_dun_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label class="form-label">Senarai KRT</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lakhq_krt_id" name="lakhq_krt_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label class="form-label">Senarai Etnik/Kaum</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lakhq_kaum_id" name="lakhq_kaum_id" >
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($kaum as $item)                          
												@if($item->kaum_description == 'MELAYU' OR $item->kaum_description == 'CINA' OR $item->kaum_description == 'INDIA' OR $item->kaum_description == 'ETNIK SABAH' OR $item->kaum_description == 'BUMIPUTERA SARAWAK' OR $item->kaum_description == 'ORANG ASLI (SEMENANJUNG)' OR $item->kaum_description == 'LAIN-LAIN ETNIK') 
                                                <option value="{{ $item->kaum_description }}" style="font-weight:bold;">{{ $item->kaum_description }}</option>
												@else
												<option value="{{ $item->kaum_description }}">{{ $item->kaum_description }}</option>
												@endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label class="form-label">Senarai Pendidikan</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lakhq_pendidikan_id" name="lakhq_pendidikan_id" >
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($pendidikan as $item)                                    
                                                <option value="{{ $item->pendidikan_description }}">{{ $item->pendidikan_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3">
                                    <label class="form-label">Senarai Jawatan</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lakhq_jawatan_id" name="lakhq_jawatan_id" >
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($jawatan as $item)                                    
                                                <option value="{{ $item->jawatan_description }}">{{ $item->jawatan_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-3">
                                    <label class="form-label">Penggal</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lakppd_penggal_id" name="lakppd_penggal_id" >
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($penggal as $item)                                    
                                                <option value="{{ $item->id }}">{{ $item->penggal_mula }}/{{ $item->penggal_tamat }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Ahli Jawatankuasa Kawasan Rukun Tetangga'</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_ajk_krt_hqrt" style="width: 4000px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50"><font color="white">Bil</font></th>
                                                <th style="background-color: #113f50"><font color="white">Negeri</font></th>
                                                <th style="background-color: #113f50"><font color="white">Daerah</font></th>
                                                <th style="background-color: #113f50"><font color="white">Parlimen</font></th>
                                                <th style="background-color: #113f50"><font color="white">Dun</font></th>
												<th style="background-color: #113f50"><font color="white">Penggal</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama KRT</font></th>
                                                <th style="background-color: #113f50"><font color="white">Nama Ahli</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Kad Pengenalan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Alamat</font></th>
                                                <th style="background-color: #113f50"><font color="white">Jantina</font></th>
                                                <th style="background-color: #113f50"><font color="white">Etnik / Kaum</font></th>
                                                <th style="background-color: #113f50"><font color="white">Agama</font></th>
                                                <th style="background-color: #113f50"><font color="white">Pendidikan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Pekerjaan</font></th>
                                                <th style="background-color: #113f50"><font color="white">Jawatan KRT</font></th>
                                                <th style="background-color: #113f50"><font color="white">No Telefon</font></th>
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
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="//cdn.datatables.ne/buttons/1.10.20/css/buttons.dataTables.min.css">
@stop

@include('js.rt-sm30.j-laporan-ajk-krt-hqrt')