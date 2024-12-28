@extends('layout.master')
@section('title', 'Pengesahan Rekod Penerimaan & Pengeluaran Kewangan')
@section('content')
@include('modal.modal-view-dokumen_kewangan')
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
                	<div class="card border border-info">
						<form action="#" id="form_mag">
                    		<div class="card-header">
                        		<h3 class="card-title text-primary"><b>Carian</b></h3>
                    		</div>
                    		<div class="card-body">
                        		<div class="row">
									{{ csrf_field() }}
                            		<div class="col-lg-4 col-md-3 col-sm-3">
										<input type="hidden" id="mag_kew_id" name="mag_kew_id">
										<input type="hidden" id="mag_kew_status" name="mag_kew_status">
										<input type="hidden" id="mag_kew_noted" name="mag_kew_noted">
                                		<label class="form-label">Senarai KRT</label>
                                		<div class="form-group">
                                    		<select class="custom-select" id="prkpd_krt_id" name="prkpd_krt_id">
                                        		<option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        		@foreach($krt as $item)                                    
                                            		<option value="{{ $item->id}}">{{ $item->krt_nama }}</option>
                                        		@endforeach
                                    		</select>
                                		</div>
                            		</div>
                        		</div>
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label class="form-label">Bulan: </label>
												<select class="form-control" name="lkr_bulan" id="lkr_bulan" placeholder="bulan kewangan">
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
									</div>
									<div class="col-md-2">
										<div class="form-group">
											<label class="form-label">Tahun: </label>
											<select class="form-control" name="lkr_tahun" id="lkr_tahun" placeholder="Tahun kewangan">
												<option value="0000">Semua</option>                              
                                            	<option value="2022">2022</option>
												<option value="2023">2023</option>
												<option value="2024">2024</option>
												<option value="2025">2025</option>
												<option value="2026">2026</option>
											</select>
										</div>
									</div>
									<div class="col-md-2" id="divpenyata" name="divpenyata" style="display:none;">
										<div class="form-group">
											<label class="form-label">&nbsp;</label>
											<input type="button" value="Penyata Bank" onclick="lihat(1,0);">
										</div>
									</div>
									<div class="col-md-2" style="display:block;">
										<table id="senarai_penyata" name="senarai_penyata" style="width: 100%; display:none;">
										</table>
										<table id="senarai_dokumen" name="senarai_dokumen" style="width: 100%; display:none;">
										</table>
									</div>
								</div>
								<div class="row">
									<label id="prolab" name="prolab" style="color:#0033FF; display:none;"><b>Proses...................</b></label>
								</div>
							</div>
						</form>
                    </div>
                </div>
                <div class="card">
                	<div class="card-header">
                    	<h3 class="card-title text-primary"><b>Senarai Kewangan Kawasan Rukun Tetangga</b></h3>
                    </div>
					<div class="col-xl-12 col-lg-12 col-md-12" id="divlabel">
                    	<div class="card-body">
							<div class="row">
								<div class="col-md-4"><b>Nama Rukun Tetangga: </b></div>
								<div class="col-md-6"><b>Alamat Rukun Tetangga:</b></div>
							</div>
							<div class="row">
								<div class="col-md-4"><label id="disp_nama_krt" name="disp_nama_krt"></label></div>
								<div class="col-md-6"><label id="disp_alamat_krt" name="disp_alamat_krt"></label></div>
							</div>
							<div class="row">
								<div class="col-md-4"><b>Nama Bank:</b></div>
								<div class="col-md-4"><b>No. Akaun Bank:</b></div>
								<div class="col-md-4" style="display:none;"><b>No. Evendor:</b></div>
							</div>
							<div class="row">
								<div class="col-md-4"><label id="disp_nama_bank" name="disp_nama_bank"></label></div>
								<div class="col-md-4"><label id="disp_acc_bank" name="disp_acc_bank"></label></div>
								<div class="col-md-4" style="display:none;"><label id="disp_evendor" name="disp_evendor"></label></div>
							</div>
						</div>
					</div>
                    <div class="col-xl-12 col-lg-12 col-md-12">
                    	<div class="card-body">
                        	<div class="table-responsive">
								<table id="senarai_trx" name="senarai_trx" style="width: 100%; display:none;">
								</table>
                                <table class="table cell-border table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table" style="width: 100%; display:none;">
                                	<thead>
                                    	<tr>
                                        	<th style="background-color: #113f50"><font color="white">ID</font></th>
                                            <th style="background-color: #113f50"><font color="white">Tindakan</font></th>
                                            <th style="background-color: #113f50"><font color="white">Note</th>
                                        </tr>
                                	</thead>
                             	</table>
                        	</div>
							<div class="table-responsive">
								<table class="table table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table3" style="width: 100%; background-color:#999999; border:1px solid;">
                                	<thead>
											<tr>
												<th rowspan="2" width="5%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>BIL</b></th>
												<th rowspan="2" width="10%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>TARIKH</b></th>
												<th rowspan="2" width="25%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>butiran</b></th>
												<th colspan="2" width="14%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>penerimaan</b></th>
												<th colspan="2" width="14%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>pembayaran</b></th>
												<th colspan="2" width="14%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>baki</b></th>
												<th rowspan="2" width="18%" style="border:1px solid; color:#FFFFFF; text-align:center"><b>tindakan</b></th>
											</tr>
											<tr>
												<th width="7%" style="border:1px solid; color:#FFFFFF; text-align:center">Tunai</th>
												<th width="7%" style="border:1px solid; color:#FFFFFF; text-align:center">Bank</th>
												<th width="7%" style="border:1px solid; color:#FFFFFF; text-align:center">Tunai</th>
												<th width="7%" style="border:1px solid; color:#FFFFFF; text-align:center">Bank</th>
												<th width="7%" style="border:1px solid; color:#FFFFFF; text-align:center">Tunai</th>
												<th width="7%" style="border:1px solid; color:#FFFFFF; text-align:center">Bank</th>
											</tr>
                           			</thead>
                          		</table>
								<table class="table cell-border table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table4" style="width: 100%">
                          		</table>
                          	</div>
                    	</div>
                  	</div>
					<div class="col-xl-12 col-lg-12 col-md-12" id="divtindakan">
                    	<div class="card-body">
							<div class="row">
								<div class="col-sm-4">
									<button type="button" class="btn btn-primary" id="btn_submit">Kemaskini Status&nbsp;&nbsp;<i class="dropdown-icon fa fa-paper-plane"></i></button>
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
.pagination li:hover{
    cursor: pointer;
}
</style>
@stop

@include('js.rt-sm7.j-pengesahan-rekod-kewangan-rt')
