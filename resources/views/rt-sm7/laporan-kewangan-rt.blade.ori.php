@extends('layout.master')
@section('title', 'Laporan Kewangan RT')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>&nbsp;</div>
                <div class="header-action">
                    <button type="button" class="btn btn-primary" title="Cetak Laporan Kewangan RT" onclick="print_laporan_kewangan_rt();"><i class="fa fa-print mr-2"></i>Cetak Laporan Kewangan RT</button>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
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
										<div class="col-md-4">
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
													<option value="2022">2022</option>
													<option value="2023">2023</option>
													<option value="2024">2024</option>
													<option value="2025">2025</option>
													<option value="2026">2026</option>
												</select>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="form-label">&nbsp;</label>
												<input type="button" class="btn btn-primary" id="cari_kewangan" name="cari_kewangan" value="Cari">
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="form-label">Baki Awal tunai: 
												<input type="text" class="form-control" name="lkr_baki_tunai_awal" id="lkr_baki_tunai_awal" disabled>	
												</label>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label class="form-label">Baki Awal bank: 
												<input type="text" class="form-control" name="lkr_baki_bank_awal" id="lkr_baki_bank_awal" disabled></label>
											</div>
										</div>
									</div>
								</div>
						</div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                        	<div class="card-body">
                            	<div class="table-responsive">
									{{ $krt->krt_nama}}
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
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table" style="width: 100%;display:none;">
                                    	<thead>
                                        	<tr>
                                            	<th style="background-color: #999999" rowspan="2"><font color="white"><b>Bil</b></font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white"><b>Butiran</b></font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white"><b>Tarikh<br> Penerimaan /Pembayaran</b></font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white"><b>No Cek / No Baucer</b></font></th>
                                                <th style="background-color: #113f50" rowspan="2"><font color="white"><b>Tarikh Cek / Tarikh Baucer</b></font></th>
                                                <th style="background-color: #113f50" colspan="2" class="text-center"><font color="white"><b>Penerimaan</b></font></th>
                                                <th style="background-color: #113f50" colspan="2" class="text-center"><font color="white"><b>Pembayaran</b></font></th>
                                                <th style="background-color: #113f50" colspan="2" class="text-center"><font color="white"><b>Baki</b></font></th>
                                            </tr>                                            <tr>
                                            	<th style="background-color: #113f50"><font color="white"><b>Tunai</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Bank</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Tunai</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Bank</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Tunai</b></font></th>
                                                <th style="background-color: #113f50"><font color="white"><b>Bank</b></font></th>
                                            </tr>
                                     	</thead>
                                    </table>
									<table class="table table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table2" style="width: 100%">
                                    	<thead>
                                        	<tr>
                                            	<th style="background-color: #999999; border:1px solid;" rowspan="2"><font color="white"><b>Bil</b></font></th>
                                                <th style="background-color: #999999; border:1px solid;" rowspan="2"><font color="white"><b>Butiran</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;" rowspan="2"><font color="white"><b>Tarikh<br> Penerimaan /Pembayaran</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;" rowspan="2"><font color="white"><b>No Cek / No Baucer</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;" rowspan="2"><font color="white"><b>Tarikh Cek / Tarikh Baucer</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;" colspan="2" class="text-center"><font color="white"><b>Penerimaan</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;" colspan="2" class="text-center"><font color="white"><b>Pembayaran</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;" colspan="2" class="text-center"><font color="white"><b>Baki</b></font></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Tunai</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Bank</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Tunai</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Bank</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Tunai</b></font></th>
                                                <th style="background-color: #999999;border:1px solid;"><font color="white"><b>Bank</b></font></th>
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
