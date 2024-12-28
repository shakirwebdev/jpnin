@extends('layout.master')
@section('title', 'Laporan Kewangan RT')
@section('content')
@include('modal.modal-view-dokumen-sokongan')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
	
    <div class="section-body mt-3" id="divcarian" name="divcarian" style="display:none;">
    	<div class="container-fluid">
        	<div class="tab-content mt-3">
            	<div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                	<div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary"><b>Carian Kawasan Rukun Tetangga</b></h3>
							<input type="hidden" id="load_state_id" name="load_state_id" value="{{ Auth::user()->state_id }}">
							<input type="hidden" id="load_daerah_id" name="load_daerah_id" value="{{ Auth::user()->daerah_id }}">
							<input type="hidden" id="load_krt_id" name="load_krt_id" value="{{ Auth::user()->krt_id }}">
                        </div>
						<div class="card-body">
							<div class="container">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
                                        	<label class="form-label">Negeri : </label>
											<select class="form-control" name="lkr_carian_negeri" id="lkr_carian_negeri" placeholder="Negeri">
												<option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
												@foreach($state as $item)                                    
                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                @endforeach
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
                                        	<label class="form-label">Daerah : </label>
											<select class="form-control" name="lkr_carian_daerah" id="lkr_carian_daerah" placeholder="Daerah" disabled>
												<option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-8">
										<div class="form-group">
                                        	<label class="form-label">Kawasan Rukun Tetangga : </label>
											<select class="form-control" name="lkr_carian_krt" id="lkr_carian_krt" placeholder="KRT" disabled>
											</select>
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
	
    <div class="section-body mt-3" id="divinfokrt" name="divinfokrt" style="display:none;">
    	<div class="container-fluid">
        	<div class="tab-content mt-3">
            	<div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                	<div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Kewangan RT</h3>
                        </div>
						<div class="card-body">
								<div class="container">
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
                                                <label class="form-label">Nama KRT: </label>
                                                <input type="text" class="form-control" name="lkr_krt_nama" id="lkr_krt_nama" placeholder="Nama KRT" disabled>
                                            </div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
                                                <label class="form-label">No Akaun: </label>
                                                <input type="text" class="form-control" name="lkr_no_acc" id="lkr_no_acc" placeholder="No Akaun" disabled>
                                            </div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
                                                <label class="form-label">Nama Bank: </label>
                                                <input type="text" class="form-control" name="lkr_bank_nama" id="lkr_bank_nama" placeholder="Nama Bank" disabled>
                                            </div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-4" style="display:none; ">
											<div class="form-group">
                                                <label class="form-label">No E-Vendor: </label>
                                                <input type="text" class="form-control" name="lkr_no_evendor" id="lkr_no_evendor" placeholder="No E-Vendor" disabled>
                                            </div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
                                                <label class="form-label">Daerah: </label>
                                                <input type="text" class="form-control" name="lkr_daerah" id="lkr_daerah" placeholder="Daerah" disabled>
                                            </div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
                                                <label class="form-label">Negeri: </label>
                                                <input type="text" class="form-control" name="lkr_negeri" id="lkr_negeri" placeholder="Negeri" disabled>
                                            </div>
										</div>
									</div>
								</div>
								<div class="container">
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
										<div class="col-sm-1">
											<div class="form-group">
												<label class="form-label">&nbsp;</label>
												<input type="button" class="btn btn-primary" id="cari_kewangan" name="cari_kewangan" value="Cari">
											</div>
										</div>
										<div class="col-sm-3.5" id="button_excel" name="button_excel">
											<div class="form-group">
												<label class="form-label">&nbsp;</label>
												<input type="button" class="btn btn-secondary" id="btn_excel" name="btn_excel" value="Muat Turun Laporan Kewangan(EXCEL)">
											</div>
										</div>
										<div class="col-sm-3" id="button_pdf" name="button_pdf">
											<div class="form-group">
												<label class="form-label">&nbsp;</label>
												<input type="button" class="btn btn-secondary" id="btn_pdf" name="btn_pdf" value="Cetak Laporan Kewangan(PDF)">
											</div>
										</div>
									</div>
								</div>
						</div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                        	<div class="card-body">
                            	<div class="table-responsive">
									<table id="senarai_trans" name="senarai_trans" style="display:none;">
										@foreach($krt_kewangan as $item)
										<tr>
											<td>{{ $item->kew_bulan }}</td>
											<td>{{ $item->kew_tahun }}</td>
											<td>{{ $item->kew_jenis }}</td>
											<td>{{ $item->kew_tunai }}</td>
											<td>{{ $item->kew_bank }}</td>
											<td>{{ $item->tarikh_kewangan }}</td>
										</tr>
										@endforeach
									</table>
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table" style="width: 100%; display:none;">
                                    </table>
									<table class="table cell-border table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table2" style="width: 100%">
                                    	<thead>
                                        	<tr>
                                            	<th width="4%" style="background-color: #999999; border:1px solid;" rowspan="2"><font color="white"><b>Bil</b></font></th>
                                                <th width="8%" style="background-color: #999999; border:1px solid;" rowspan="2"><font color="white"><b>Tarikh<br> Penerimaan/ Pembayaran</b></font></th>
                                                <th width="16%" style="background-color: #999999;border:1px solid;" rowspan="2"><font color="white"><b>Butir-Butir<br> Penerimaan/ Pembayaran</b></font></th>
                                                <th width="8%" style="background-color: #999999;border:1px solid;" rowspan="2"><font color="white"><b>No Cek/<br> Tarikh Cek</b></font></th>
                                                <th width="8%" style="background-color: #999999;border:1px solid;" rowspan="2"><font color="white"><b>No Resit/<br> Tarikh Resit</b></font></th>
												<th width="8%" style="background-color: #999999;border:1px solid;" rowspan="2"><font color="white"><b>No Baucer/<br> Tarikh Baucer</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;" colspan="2" class="text-center"><font color="white"><b>Penerimaan</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;" colspan="2" class="text-center"><font color="white"><b>Pembayaran</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;" colspan="3" class="text-center"><font color="white"><b>Baki</b></font></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Tunai</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Bank</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Tunai</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Bank</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Tunai</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Bank</b></font></th>
												<th style="background-color: #999999;border:1px solid;"><font color="white"><b>Jumlah</b></font></th>
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
@stop

@include('js.rt-sm7.j-laporan-kewangan-rt')