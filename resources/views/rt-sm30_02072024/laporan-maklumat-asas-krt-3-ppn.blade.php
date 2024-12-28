@extends('layout.master')
@section('title', 'Laporan Maklumat Asas RT 3')


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
                                    <label class="form-label">Senarai Daerah</label>
                                    <div class="form-group">
                                        <select class="custom-select" id="lmak3pn_daerah_id" name="lmak3pn_daerah_id">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                            @foreach($daerah as $item)                                    
                                                <option value="{{ $item->daerah_description }}">{{ $item->daerah_description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Laporan Maklumat Asas RT</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_maklumat_asas_rt_3" style="width: 3000px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Nama KRT</font></label></th>
                                                <th style="background-color: #113f50" colspan="9" class="text-center"><label class="form-label"><font color="white">Kategori Rumah</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Senarai Kemudahan Awam</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Senarai Isu Dalam Kawasan</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Senarai masalah sosial Dalam Kawasan</font></label></th>
                                                <th style="background-color: #113f50" rowspan="2"><label class="form-label"><font color="white">Senarai Kawasan Pertanian</font></label></th>
                                            </tr>
                                            <tr>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Rumah Sebuah</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Rumah Teres</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Rumah Kampung</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Setinggan</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Rumah (Semi-D)</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Rumah Pangsa atau Flat</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Kondominium</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Apartment</font></label></th>
                                                <th style="background-color: #113f50"><label class="form-label"><font color="white">Rumah Kedai</font></label></th>
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

@include('js.rt-sm30.j-laporan-maklumat-asas-krt-3-ppn')