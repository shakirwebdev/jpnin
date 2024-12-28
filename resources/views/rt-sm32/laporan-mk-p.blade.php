@extends('layout.master')
@section('title', 'Laporan Senarai Nama MK mengikut Negeri')


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
                                        <select class="custom-select" id="lm_state_id" name="lm_state_id">
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
                                        <select class="custom-select" id="lm_daerah_id" name="lm_daerah_id" disabled>
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">-- Sila Pilih --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title text-primary">Senarai Nama MK</h3>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-vcenter table-hover mb-0" id="laporan_mk" style="width: 3000px">
                                        <thead>
                                            <tr>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Bil</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Negeri</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Daerah</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Parlimen</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Dun</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">PBT</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Mukim</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Nama</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">No Kad Pengenalan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Kaum</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Umur</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Pendidikan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Email</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">No Telefon</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Pengkhususan (Kemahiran)</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Alamat Pejabat</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Alamat Rumah</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Kategori MKP</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Tahap MKP</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Tarikh Dilantik</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Status Pelanjutan</font></label></th>
                                                <th style="background-color: #113f50" ><label class="form-label text-center"><font color="white">Nama KRT</font></label></th>
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

@include('js.rt-sm32.j-laporan-mk-p')