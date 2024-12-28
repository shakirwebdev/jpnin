@extends('layout.master')
@section('title', 'Rekod Penerimaan & Pengeluaran Kewangan')


@section('content')
@include('modal.modal-view-butiran')
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
                    <button type="button" class="btn btn-primary" onclick="window.location.href = '{{route('rt-sm7.add_rekod_kewangan_rt')}}';"><i class="fe fe-plus mr-2"></i>Tambah Maklumat Kewangan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" role="tabpanel">
					<div class="card border border-info">
                    	<div class="card-header">
                        	<h3 class="card-title text-primary"><b>Carian</b></h3>
                        </div>
                        <div class="card-body pl-4 pt-2 pr-4 pb-2">
                        	<div class="row">
                                <div class="col-sm-4">
									<label class="form-label">Bulan Kewangan :</label>
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
										<label class="form-label">Tahun Kewangan:</label>
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
                    </div>
				</div>
				<div class="tab-pane fade show active" role="tabpanel">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary"><b>Senarai Kewangan Kawasan Rukun Tetangga</b></h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table" style="display:none; ">
                                    </table>
                                </div>
								<div class="table-responsive">
                                   <table class="table cell-border table-vcenter table-hover mb-0" id="senarai_kewangan_rt_table2" style="width: 120%;">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" width="2%" style="background-color: #999999; border:1px solid; text-align:left;"><font color="white"><b>Bil</b></font></th>
                                                <th rowspan="2" width="3%" style="background-color: #999999; border:1px solid; text-align:left;"><font color="white"><b>Tarikh</b></font></th>
                                                <th rowspan="2" width="12%" style="background-color: #999999; border:1px solid; text-align:left;"><font color="white"><b>Butiran</b></font></th>
												<th colspan="2" width="15%" style="background-color: #999999; border:1px solid; text-align:center;"><font color="white"><b>Penerimaan</b></font></th>
												<th colspan="2" width="15%" style="background-color: #999999; border:1px solid; text-align:center;"><font color="white"><b>Pembayaran</b></font></th>
												<th colspan="2" width="15%" style="background-color: #999999; border:1px solid; text-align:center;"><font color="white"><b>Baki</b></font></th>
                                                <th rowspan="2" width="7%" style="background-color: #999999; border:1px solid; text-align:left;"><font color="white"><b>Status</b></font></th>
                                                <th rowspan="2" width="7%" style="background-color: #999999; border:1px solid; text-align:left;"><font color="white"><b>Tindakan</b></font></th>
                                            </tr>
											<tr>
													<th width="3%" style="background-color: #999999; border:1px solid;"><font color="white">Tunai</th>
													<th width="3%" style="background-color: #999999; border:1px solid;"><font color="white">Bank</th>
													<th width="3%" style="background-color: #999999; border:1px solid;"><font color="white">Tunai</th>
													<th width="3%" style="background-color: #999999; border:1px solid;"><font color="white">Bank</th>
													<th width="3%" style="background-color: #999999; border:1px solid;"><font color="white">Tunai</th>
													<th width="3%" style="background-color: #999999; border:1px solid;"><font color="white">Bank</th>
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
<style>
.menegak {
  writing-mode: vertical-lr;
  text-orientation: upright;
}
</style>
@stop

@include('js.rt-sm7.j-senarai-rekod-kewangan-rt')
