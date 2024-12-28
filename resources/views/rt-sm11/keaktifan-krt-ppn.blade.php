@extends('layout.master')
@section('title', 'Senarai Keaktifan KRT')


@section('content')
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="row clearfix">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-primary">Carian</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <label class="form-label">Senarai Negeri</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="kkhq_state_id" name="kkhq_state_id" disabled>
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($state as $item)                                    
                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
									<div class="col-lg-3 col-md-3 col-sm-3">
                                        <label class="form-label">Senarai Parlimen</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="kkhq_parlimen_id" name="kkhq_parlimen_id" disabled>
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($parlimen as $item)                                    
                                                    <option value="{{ $item->daerah_id }}">{{ $item->parlimen_description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
									<div class="col-lg-3 col-md-3 col-sm-3">
                                        <label class="form-label">Senarai Daerah</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="kkhq_daerah_id" name="kkhq_daerah_id" disabled>
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($daerah as $item)                                    
                                                    <option value="{{ $item->daerah_id }}">{{ $item->daerah_description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-3">
                                        <label class="form-label">Senarai DUN</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="kkhq_dun_id" name="kkhq_dun_id" disabled>
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($dun as $item)                                    
                                                    <option value="{{ $item->daerah_id }}">{{ $item->dun_description }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
									<div class="col-lg-6">
                                        <label class="form-label">Senarai Nama KRT</label>
                                        <div class="form-group">
                                            <select class="custom-select" id="kkhq_krt_id" name="kkhq_krt_id" disabled>
                                                <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                                @foreach($krt as $item)                                    
                                                    <option value="{{ $item->id }}">{{ $item->krt_nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
									<div class="col-md-1">
										<label class="form-label">Tahun: </label>
										<div class="form-group">
                                            <select class="custom-select" name="kkhq_tahun" id="kkhq_tahun">
												<option value="2022" style="color: #a9a9a9 !important;">2022</option>
												<option value="2023" style="color: #a9a9a9 !important;">2023</option>
												<option value="2024" style="color: #a9a9a9 !important;">2024</option>
												<option value="2025" style="color: #a9a9a9 !important;">2025</option>
												<option value="2026" style="color: #a9a9a9 !important;">2026</option>
												<option value="2027" style="color: #a9a9a9 !important;">2027</option>
                                            </select>
										</div>
                                    </div>
								</div>
                            </div>
                        </div>
						<div style="display:none;">
							<table id="data_kunci">
							</table>
							<input type="text" id="kunci_markah_ajk" value="">
							<input type="text" id="kunci_markah_aktiviti" value="">
							<input type="text" id="kunci_markah_mesyuarat" value="">
							<input type="text" id="kunci_markah_kewangan" value="">
						</div>
                        <div class="card">
							<div class="row">
                            	<div class="card-header">
                                	<h3 class="card-title text-primary">Senarai Keaktifan Kawasan Rukun Tetangga</h3>
                            	</div>
								<div class="card-header">
                                	<h3 class="card-title text-primary"><input type="button" class="btn btn-primary" id="btn_excel" name="btn_excel" value="Muat Turun Laporan Keaktifan(EXCEL)"></h3>
                            	</div>
								<div class="card-header">
                                	<h3 class="card-title text-primary"><button type="button" class="btn btn-primary" title="Cetak Laporan Keaktifan" id="btn_pdf" name="btn_pdf"><i class="fa fa-print mr-2"></i>Cetak Laporan Keaktifan(PDF)</button></h3>
                            	</div>
							</div>
                            <div class="col-xl-12 col-lg-12 col-md-12">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table cell-border table-vcenter table-hover mb-0" id="senarai_keaktifan_krt" style="width: 110%;">
                                            <thead style="background-color:#999999; border:1px solid;">
                                                <tr>
                                                    <th rowspan="2" width="4%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>BIL</b></th>
													<th rowspan="2" width="7%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>PARLIMEN</b></th>
                                                    <th rowspan="2" width="10%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>DAERAH</b></th>
                                                    <th rowspan="2" width="10%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>NAMA KRT</b></th>
													<th rowspan="2" width="10%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>NO. KRT</b></th>
                                                    <th colspan="7" width="16%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>MARKAH KEAKTIFAN(%)</b></th>
                                                    <th rowspan="2" width="18%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>STATUS</b></th>
                                                </tr>
												<tr>
													<th width="2%" class="menegak" style="border:1px solid; color:#FFFFFF; text-align:center">Profail</th>
													<th width="2%" class="menegak" style="border:1px solid; color:#FFFFFF; text-align:center">AJK</th>
													<th width="2%" class="menegak" style="border:1px solid; color:#FFFFFF; text-align:center">Aktiviti</th>
													<th width="2%" class="menegak" style="border:1px solid; color:#FFFFFF; text-align:center">Mesyuarat</th>
													<th width="2%" class="menegak" style="border:1px solid; color:#FFFFFF; text-align:center">Kewangan</th>
													<th width="2%" class="menegak" style="border:1px solid; color:#FFFFFF; text-align:center">Manual</th>
													<th width="4%" class="menegak" style="border:1px solid; color:#FFFFFF; text-align:center">Jumlah</th>
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
<style>
.menegak {
  writing-mode: vertical-lr;
  text-orientation: upright;
}
</style>
@stop

@include('js.rt-sm11.j-keaktifan-krt-ppn')
