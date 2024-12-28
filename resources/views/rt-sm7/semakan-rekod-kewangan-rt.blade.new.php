@extends('layout.master')
@section('title', 'Semakan Rekod Penerimaan & Pengeluaran Kewangan')


@section('content')
@include('modal.modal-view-dokumen')
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
                    <div class="card">
						<div class="card border border-info">
							<form action="#" id="form_mag">
                            <div class="card-header">
                                <h3 class="card-title text-primary"><b>Carian</b></h3>
                            </div>
                            <div class="card-body pl-4 pt-2 pr-4 pb-2">
								{{ csrf_field() }}
                                <div class="row">
                                	<div class="col-sm-4">
										<label class="form-label">Bulan test:</label>
                                        <select class="form-control" name="carian_bulan" id="carian_bulan">
											<option value="00">Semua</option>                              
                                            <option value="01">Januari</option>
											<option value="02">Februari</option>
											<option value="03">Mac</option>
											<option value="04">April</option>
											<option value="05">Mei</option>
											<option value="06">Jun</option>
											<option value="07">Julai</option>
											<option value="08">Ogos</option>
											<option value="09">September</option>
											<option value="10">Oktober</option>
											<option value="11">November</option>
											<option value="12">Disember</option>
                                    	</select>
									</div>
									<div class="col-sm-2 form-group">
										<label class="form-label">Tahun :</label>
                                        <select class="form-control" name="carian_tahun" id="carian_tahun">  
											<option value="0000">Semua</option>                              
                                            <option value="2022">2022</option>
											<option value="2023">2023</option>
											<option value="2024">2024</option>
											<option value="2025">2025</option>
											<option value="2026">2026</option>
                                    	</select>
                                    </div>
                            	</div>
                                <div class="row" id="divpenyata">
									<div class="col-sm-4 form-group">
										<label class="form-label">Penyata Bank : <span class="text-red">*</span></label>
										<input type="file" class="form-control" name="mag_file_dokumen" id="mag_file_dokumen" placeholder="Fail Penyata Bank">
										<div class="error_mag_file_dokumen invalid-feedback text-right"></div>
										<input type="hidden" id="mag_krt_id" name="mag_krt_id" value="">
										<input type="hidden" id="mag_id" name="mag_id" value="">
										<input type="hidden" id="mag_filename" name="mag_filename" value="">
									</div>
									<div class="col-sm-2.5 form-group">
										<label class="form-label">&nbsp;</label>
										<input type="button" class="btn btn-secondary" id="upload_dokumen" name="upload_dokumen" value="Muatnaik">
									</div>
									<div class="col-sm-2 form-group">
										<label class="form-label">&nbsp;</label>
										<button id="lihat_dokumen" name="lihat_dokumen" type="button" class="btn btn-secondary" onclick="lihat();">Lihat</button>
									</div>
                               </div>
                        </div>
					</div>
					<div class="tab-pane fade show active" role="tabpanel">
                        <div class="card-header">
                            <h3 class="card-title text-primary"><b>Senarai Kewangan Kawasan Rukun Tertangga <label id="lab_bagi" name="lab_bagi" style="display:none;">bagi </label> <label id="penyata_bulan" name="penyata_bulan"></label>&nbsp;<label id="penyata_tahun" name="penyata_tahun"></label></b></h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table" style="width: 100%; display:block;">
                                    </table>
                                </div>
								<div class="table-responsive">
                                    <table width="100%" class="table cell-border table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table2">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white"><b>Bil</b></font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white"><b>Tarikh/Masa<br>Kewangan</b></font></th>
												<th style="background-color: #999999; border:1px solid;"><font color="white"><b>Jenis Kewangan</b></font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white"><b>Butiran</b></font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white"><b>Status</b></font></th>
                                                <th style="background-color: #999999; border:1px solid;"><font color="white"><b>Tindakan</b></font></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
						<div class="card-body" id="div_tindakan" name="div_tindakan" display="none;">
                                <div class="row">
                                	<div class="col-sm-4">
										<label class="form-label">Tindakan Pengerusi test: <span class="text-red">*</span></label>
                                        <select class="form-control" name="srkr_1_tindakan_status" id="srkr_1_tindakan_status">
											<option value="3">Dihantar Untuk Pengesahan</option>
                                        </select>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-sm-4">
                                        <label class="form-label">Penerangan: <span class="text-red">*</span></label>
                                        <textarea class="form-control" rows="4" name="srkr_1_semak_noted" id="srkr_1_semak_noted"></textarea>
                                        <div class="error_srkr_1_semak_noted invalid-feedback text-right"></div>
										<input type="hidden" id="data_bulan" name="data_bulan">
										<input type="hidden" id="data_tahun" name="data_tahun">
                                    </div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<label class="form-label">&nbsp;</label>
										<button type="button" class="btn btn-primary" id="btn_submit">Hantar Laporan ke PPD&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
									</div>
                                </div>
                        </div>
						</form>
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

@include('js.rt-sm7.j-semakan-rekod-kewangan-rt')