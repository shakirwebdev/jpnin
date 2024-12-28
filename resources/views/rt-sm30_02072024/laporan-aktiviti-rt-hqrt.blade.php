@extends('layout.master')
@section('title', 'Laporan Aktiviti RT')


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
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Negeri</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larhq_state_id" name="larhq_state_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($state as $item)                                    
                                                <option value="{{ $item->state_description }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Senarai Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larhq_daerah_id" name="larhq_daerah_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Agenda Kerja</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larhq_agenda_id" name="larhq_agenda_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($agenda as $item)                                    
                                                <option value="{{ $item->agenda_description }}">{{ $item->agenda_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Bidang</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larhq_bidang_id" name="larhq_bidang_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($bidang as $item)                                    
                                                <option value="{{ $item->bidang_description }}">{{ $item->bidang_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Kategori Aktiviti</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larhq_k_aktiviti_id" name="larhq_k_aktiviti_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($k_aktiviti as $item)                                    
                                                <option value="{{ $item->aktiviti_description }}">{{ $item->aktiviti_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <label class="form-label">Jenis Kategori Aktiviti</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="larhq_j_aktiviti_id" name="larhq_j_aktiviti_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($j_aktiviti as $item)                                    
                                                <option value="{{ $item->aktiviti_description }}">{{ $item->aktiviti_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
						<div class="row">
							<div class="card-header">
								<h3 class="card-title text-primary">Laporan Aktiviti RT</h3>
							</div>
							<div class="col-sm-3.5" id="button_excel" name="button_excel">
								<div class="form-group">
									<label class="form-label">&nbsp;</label>
									<input type="button" class="btn btn-secondary" id="btn_excel" name="btn_excel" value="Muat Turun Laporan Aktiviti(EXCEL)">
								</div>
							</div>
							<div class="col-sm-3" id="button_pdf" name="button_pdf">
								<div class="form-group">
									<label class="form-label">&nbsp;</label>
									<input type="button" class="btn btn-secondary" id="btn_pdf" name="btn_pdf" value="Cetak Laporan Aktiviti(PDF)">
								</div>
							</div>
						</div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table cell-border table-vcenter table-hover mb-0" id="laporan_aktiviti" style="width: 3000px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Nama KRT</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Penganjur</font></label></th>
												<th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Tarikh</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Tajuk Aktiviti</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Perasmi</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Agenda Kerja</font></label></th>
												<th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Program</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Bidang</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Kategori Aktiviti</font></label></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><label class="form-label"><font color="white">Jenis Kategori Aktiviti</font></label></th>
												<th style="background-color: #999999; border:1px solid;" colspan="2" class="text-center"><label class="form-label"><font color="white">Jantina</font></label></th>
												<th style="background-color: #999999; border:1px solid;" colspan="7" class="text-center"><label class="form-label"><font color="white">Umur</font></label></th>
                                            </tr>
											<tr>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white">Lelaki</font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white">Perempuan</font></th>
												<th style="background-color: #999999; border:1px solid;"><font color="white">0 - 6</font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white">07 - 12</font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white">13 - 17</font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white">18 - 35</font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white">36 - 45</font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white">45 - 59</font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white">60 Keatas</font></th>
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

@include('js.rt-sm30.j-laporan-aktiviti-rt-hqrt')