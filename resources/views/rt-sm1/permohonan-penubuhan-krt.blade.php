@extends('layout.master')
@section('parentPageTitle', 'HRMS')
@section('title', 'Permohonan Cadangan Nama Kawasan Rukun Tetangga (KRT)')


@section('content')
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                &nbsp;
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="mb-4">
                        <small>Isi maklumat pada borang yang disediakan dibawah, dan tekan butang HANTAR. 
                        <br>
                        Ruangan bertanda <span class="text-red">*</span> adalah ruangan mandatori dan perlu diisi..&nbsp;&nbsp;<a href="#"><i class="dropdown-icon fe fe-help-circle"></i></a></small>
                    </div>                        
                </div>
            </div>
            <div class="tab-content mt-3">
                <?php
                    $disabled = "";
                    if ($applicant && $applicant->is_edit==0) {                                                
                        $disabled = "disabled";
                    }
                    if ($applicant && $applicant->status == 3) {                                                
                        $disabled = "";
                    }
                ?>
                @if ($applicant && $applicant->is_edit==0 && $applicant->status==1)
                <div class="alert alert-warning alert-dismissible fade show small" role="alert" id="krt_kemaskini">
                    <div class="mb-10">
                        <code><span style="text-size: 16px;"><strong>No Rujukan Permohonan : RT{{$applicant->state_id}}{{$applicant->daerah_id}}{{$applicant->id}}</strong></span></code>
                        <br>
                        <br>
                        Permohonan Penubuhan Kawasan Rukun Tetangga (KRT) sedang dalam proses tindakan dan pengesahan oleh pihak Pengarah Perpaduan Negeri (PPN) dan Pegawai Perpaduan Daerah (PPD). 
                        <br>
                        <br>
                        Sepanjang proses pengesahan ini, maklumat yang dibekalkan di-'kunci' untuk seketika. Untuk membuat perubahan, sila tekan butang "Permohonan Mengubah Kandungan" dibawah dan sebahagian dari maklumat 
                        sahaja dibenarkan perubahan dibuat. 
                    </div>
                    <form method="POST" action="{{ route('rt-sm1.unlock_permohonan_penubuhan_krt') }}">
                    @csrf
                    <input type="hidden" name="application_id" value="{{$applicant->id}}">
                    <button type="submit" class="btn btn-primary btn-xs mb-2">Permohonan Mengubah Kandungan</button>
                    <button type="button" class="btn btn-secondary btn-xs mb-2" onclick="window.location.href = '{{route('rt-sm1.status_permohonan_penubuhan_krt')}}';">Semak Permohonan</button>
                    
                    </form>
                </div>
                @endif
                @if ($applicant && $applicant->status==3)
                <div class="alert alert-warning alert-dismissible fade show small" role="alert">
                    <div class="mb-10">
                        <code><span style="text-size: 16px;"><strong>No Rujukan Permohonan : RT{{$applicant->state_id}}{{$applicant->daerah_id}}{{$applicant->id}}</strong></span></code>
                        <br><br>
                        <code><span style="text-size: 16px;"><strong>Status:</strong></span></code><b> <span style="font-size: 14px;" class="text-red blink" id="krt_status_description" name="krt_status_description"></span></b>
                        <br><br>
                        <code><span style="text-size: 16px;"><strong>Note:</strong></span></code> <span id="krt_disemak_note" name="krt_disemak_note"></span>.
                        <br>
                        <input type="hidden" name="krt_status" id="krt_status">
                    </div>
                </div>
                @endif
                @if(\Session::has('success'))
                    <div class="form-group">
                        <div class="col-lg-12 alert alert-success text-sm-left">
                            <small>{{\Session::get('success')}}</small>
                        </div>
                    </div>
                @endif
                <div class="tab-pane fade show active" id="user-list" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            @if (!$applicant || ($applicant && $applicant->is_edit==1) || ($applicant && $applicant->status==3))
                            <form method="POST" action="{{ route('rt-sm1.permohonan_penubuhan_krt') }}">
                            @csrf
                            @endif                            
                            <div class="row clearfix">                                
                                <div class="col-12">
                                    <h6>JENIS PERMOHONAN</h6>
                                    <hr class="mt-1">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <div class="custom-switches-stacked">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label class="custom-switch">
                                                        <input type="radio" name="krt-jenis" value="1" class="custom-switch-input" checked>
                                                        <span class="custom-switch-indicator"></span>
                                                        <span class="custom-switch-description">Permohonan Penubuhan Kawasan Rukun Tetangga (KRT)</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6>MAKLUMAT PEMOHON</h6>
                                    <hr class="mt-1">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <?php
                                        if ($errors->has('krt_nama_pemohon')) {
                                            $a1 = old('krt_nama_pemohon');
                                        } else {
                                            if ($applicant) {                                                
                                                $a1 = $applicant->user_fullname;
                                            } else {
                                                $a1 = Auth::user()->profile->user_fullname;
                                            }
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label class="form-label">Nama Pemohon: <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @if ($errors->has('krt_nama_pemohon')) is-invalid @endif" name="krt_nama_pemohon" {{$disabled}} placeholder=".." value="{{$a1}}">
                                        @if($errors->has('krt_nama_pemohon'))
                                        <div class="invalid-feedback text-right">{{ $errors->first('krt_nama_pemohon') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <?php 
                                        if ($errors->has('krt_no_ic_pemohon')) {
                                            $a2 = old('krt_no_ic_pemohon');
                                        } else {
                                            if ($applicant) {
                                                $a2 = $applicant->no_ic;
                                            } else {
                                                $a2 = Auth::user()->profile->no_ic;
                                            }
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label class="form-label">No Kad Pengenalan: <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @if ($errors->has('krt_no_ic_pemohon')) is-invalid @endif" name="krt_no_ic_pemohon" {{$disabled}} placeholder=".." value="{{$a2}}">
                                        @if($errors->has('krt_no_ic_pemohon'))
                                        <div class="invalid-feedback text-right">{{ $errors->first('krt_no_ic_pemohon') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <?php 
                                        if ($errors->has('krt_no_telefon_pemohon')) {
                                            $a3 = old('krt_no_telefon_pemohon');
                                        } else {
                                            if ($applicant) {
                                                $a3 = $applicant->no_phone;
                                            } else {
                                                $a3 = Auth::user()->profile->no_phone;
                                            }
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label class="form-label">No Telefon: <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @if ($errors->has('krt_no_telefon_pemohon')) is-invalid @endif" name="krt_no_telefon_pemohon" {{$disabled}} placeholder=".." value="{{$a3}}">
                                        @if($errors->has('krt_no_telefon_pemohon'))
                                        <div class="invalid-feedback text-right">{{ $errors->first('krt_no_telefon_pemohon') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <?php 
                                        $a4 = "";
                                        if ($errors->has('krt_alamat_pemohon')) {
                                            $a4 = old('krt_alamat_pemohon');
                                        } else {
                                            if ($applicant) {
                                                $a4 = $applicant->user_address;                                            
                                            }
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label class="form-label">Alamat Pemohon: <span class="text-red">*</span></label>
                                        <textarea rows="4" class="form-control @if ($errors->has('krt_alamat_pemohon')) is-invalid @endif" name="krt_alamat_pemohon"  id="krt_alamat_pemohon" {{$disabled}} placeholder="..">{{$a4}}</textarea>
                                        @if($errors->has('krt_alamat_pemohon'))
                                        <div class="invalid-feedback text-right">{{ $errors->first('krt_alamat_pemohon') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h6>MAKLUMAT PERMOHONAN KAWASAN RUKUN TETANGGA</h6>
                                    <hr class="mt-1">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="select_negeri_krt" class="form-label">Negeri: <span class="text-red">*</span></label>
                                        <select class="custom-select @if ($errors->has('select_negeri_krt')) is-invalid @endif" {{$disabled}} name="select_negeri_krt" id="select_negeri_krt">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                            @foreach($negeri as $item)                                    
                                            <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('select_negeri_krt'))
                                        <div class="invalid-feedback text-right">{{ $errors->first('select_negeri_krt') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="select_daerah_krt" class="form-label">Daerah: <span class="text-red">*</span></label>
                                        <select class="custom-select @if ($errors->has('select_daerah_krt')) is-invalid @endif" {{$disabled}} name="select_daerah_krt" id="select_daerah_krt">
                                            <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih daerah</option>
                                        </select>
                                        @if($errors->has('select_daerah_krt'))
                                        <div class="invalid-feedback text-right">{{ $errors->first('select_daerah_krt') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <?php 
                                        $a7 = "";
                                        if ($errors->has('krt_nama')) {
                                            $a7 = old('krt_nama');
                                        } else {
                                            if ($applicant) {
                                                $a7 = $applicant->krt_name;                                            
                                            }
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label class="form-label">Cadangan Nama Kawasan Rukun Tetangga (KRT): <span class="text-red">*</span></label>
                                        <input type="text" class="form-control @if ($errors->has('krt_nama')) is-invalid @endif" name="krt_nama" {{$disabled}} placeholder=".." value="{{$a7}}">
                                        @if($errors->has('krt_nama'))
                                        <div class="invalid-feedback text-right">{{ $errors->first('krt_nama') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <?php 
                                        $a8 = "";
                                        if ($errors->has('krt_catatan')) {
                                            $a8 = old('krt_catatan');
                                        } else {
                                            if ($applicant) {
                                                $a8 = $applicant->krt_note;                                            
                                            }
                                        }
                                    ?>
                                    <div class="form-group">
                                        <label class="form-label">Alamat Cadangan Kawasan Rukun Tetangga:</label>
                                        <textarea rows="4" class="form-control" name="krt_catatan" id="krt_catatan" {{$disabled}} placeholder="..">{{$a8}}</textarea>
                                    </div>
                                </div>                                
                                <button type="button" class="btn btn-secondary"><i class="dropdown-icon fe fe-arrow-left"></i>&nbsp;Kembali</button>
                                @if ($applicant && $applicant->is_edit==0 && $applicant->status==2)

                                @elseif ($applicant && $applicant->is_edit==0 && $applicant->status==1)
                                    
                                @elseif ($applicant && $applicant->is_edit==1 && $applicant->status==1)
                                    <input type="hidden" name="application_id" value="{{$applicant->id}}">
                                    <input type="hidden" name="application_action" value="update">
                                    <button type="submit" class="btn btn-danger">Kemaskini Borang</button>
                                @elseif ($applicant && $applicant->status==3)
                                    <input type="hidden" name="application_id" value="{{$applicant->id}}">
                                    <input type="hidden" name="application_action" value="edit">
                                    <button type="submit" class="btn btn-danger">Kemaskini Borang</button>
                                @else
                                    <input type="hidden" name="application_action" value="add">
                                    <button type="submit" class="btn btn-primary">Hantar Borang Permohonan</button>
                                @endif
                                
                            </div>
                            @if (!$applicant)
                            </form>
                            @endif
                            
                        </div>
                    </div>
                </div>                
            </div>
        </div>            
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@stop

@include('js.rt-sm1.j-permohonan-penubuhan-krt')