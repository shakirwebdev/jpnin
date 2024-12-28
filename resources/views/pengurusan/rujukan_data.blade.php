@extends('layout.master')
@section('title', 'Pengurusan Rujukan Data (Lookup)')


@section('content')    
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <ul class="nav nav-tabs page-header-tab">
                    <li class="nav-item"><a class="nav-link active" id="Departments-tab" data-toggle="tab" href="#ref-daerah"><i class="fa fa-list-ul"></i>&nbsp;Daerah</a></li>
                    <li class="nav-item"><a class="nav-link" id="Departments-tab2" data-toggle="tab" href="#ref-parlimen"><i class="fa fa-list-ul"></i>&nbsp;Parlimen</a></li>
                    <li class="nav-item"><a class="nav-link" id="Departments-tab3" data-toggle="tab" href="#ref-dun"><i class="fa fa-list-ul"></i>&nbsp;DUN</a></li>
                    <li class="nav-item"><a class="nav-link" id="Departments-tab4" data-toggle="tab" href="#ref-pbt"><i class="fa fa-list-ul"></i>&nbsp;PBT</a></li>
                    <li class="nav-item"><a class="nav-link" id="Departments-tab5" data-toggle="tab" href="#ref-bandar"><i class="fa fa-list-ul"></i>&nbsp;Bandar</a></li>
                </ul>
            </div>
        </div>
    </div>    
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="ref-daerah" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari daerah..." id="myInputTextField_Daerah">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>Negeri</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_Daerah">
                                                    <option value="">Pilih untuk isihan</option>
                                                    @foreach($negeri as $item)
                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalDaerah"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Daerah</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Daerah</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="daerah_table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Kod Daerah</th>
                                                    <th>Nama Daerah</th>
                                                    <th>Negeri</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>      
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ref-parlimen" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari parlimen..." id="myInputTextField_Parlimen">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>Negeri</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_Parlimen">
                                                    <option value="">Pilih untuk isihan</option>
                                                    @foreach($negeri as $item)
                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalParlimen"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Parlimen</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Parlimen</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="parlimen_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Kod Parlimen</th>
                                                <th>Nama Parlimen</th>
                                                <th>Negeri</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>      
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ref-dun" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari DUN..." id="myInputTextField_DUN">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label>Negeri</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_DUN">
                                                    <option value="">Pilih untuk isihan</option>
                                                    @foreach($negeri as $item)
                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label>Parlimen</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_DUN_Parlimen">
                                                    <option value="">Pilih untuk isihan</option>
                                                </select>
                                            </div>
                                        </div>                                        
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalDUN"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah DUN</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Dewan Undangan Negeri (DUN)</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="dun_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Kod DUN</th>
                                                <th>Nama DUN</th>
                                                <th>Parlimen</th>
                                                <th>Negeri</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>      
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ref-pbt" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari PBT..." id="myInputTextField_PBT">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>Negeri</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_PBT">
                                                    <option value="">Pilih untuk isihan</option>
                                                    @foreach($negeri as $item)
                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalPBT"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah PBT</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Pihak Berkuasa Tempatan (PBT)</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="pbt_table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>Kod PBT</th>
                                                    <th>Nama PBT</th>
                                                    <th>Negeri</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>      
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show" id="ref-bandar" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari bandar..." id="myInputTextField_Bandar">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label>Negeri</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_Bandar">
                                                    <option value="">Pilih untuk isihan</option>
                                                    @foreach($negeri as $item)
                                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label>Daerah</label>
                                            <div class="form-group">
                                                <select class="custom-select" id="mySelectField_Bandar_Daerah">
                                                    <option value="">Pilih daerah</option>
                                                </select>
                                            </div>
                                        </div>                                        
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalBandar"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Bandar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Bandar / Kawasan / Tempat</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="bandar_table" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>Nama Bandar / Kawasan</th>
                                                <th>Daerah</th>
                                                <th>Negeri</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>      
                                        </tbody>
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

@section('popup')
    <!-- Modal -->
    <div class="modal fade" id="ModalDaerah" tabindex="-1" role="dialog" aria-labelledby="ModalDaerahLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalDaerahLabel">Tambah Daerah</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="#" id="daerah_form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                            <ul></ul>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kod_daerah">Kod Daerah:</label>
                                <input type="text" class="form-control" placeholder="Taip no id daerah" name="kod_daerah" id="kod_daerah">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_daerah">Nama Daerah:</label>
                                <input type="text" class="form-control" placeholder="Taip nama daerah" name="input_daerah" id="input_daerah">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="select_negeri">Negeri:</label>
                                <select class="custom-select" name="select_negeri" id="select_negeri">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                    @foreach($negeri as $item)                                    
                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn-save-daerah">Simpan</button>
                    <input type="hidden" name="action" id="action_daerah" value="add" />
                    <input type="hidden" name="_method" id="method_daerah" value="" />
                    <input type="hidden" name="hidden_id" id="hidden_id_daerah" />
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalParlimen" tabindex="-1" role="dialog" aria-labelledby="ModalParlimenLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalParlimenLabel">Tambah Parlimen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="#" id="parlimen_form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                            <ul></ul>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kod_parlimen">Kod Daerah:</label>
                                <input type="text" class="form-control" placeholder="Taip no id parlimen" name="kod_parlimen" id="kod_parlimen">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_parlimen">Nama Parlimen:</label>
                                <input type="text" class="form-control" placeholder="Taip nama kawasan parlimen" name="input_parlimen" id="input_parlimen">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="select_negeri_parlimen">Negeri:</label>
                                <select class="custom-select" name="select_negeri_parlimen" id="select_negeri_parlimen">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                    @foreach($negeri as $item)                                    
                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn-save-parlimen">Simpan</button>
                    <input type="hidden" name="action" id="action_parlimen" value="add" />
                    <input type="hidden" name="_method" id="method_parlimen" value="" />
                    <input type="hidden" name="hidden_id" id="hidden_id_parlimen" />
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalDUN" tabindex="-1" role="dialog" aria-labelledby="ModalDUNLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalDUNLabel">Tambah DUN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="#" id="dun_form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                            <ul></ul>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kod_dun">Kod DUN:</label>
                                <input type="text" class="form-control" placeholder="Taip no id DUN" name="kod_dun" id="kod_dun">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_dun">Nama DUN:</label>
                                <input type="text" class="form-control" placeholder="Taip nama DUN" name="input_dun" id="input_dun">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="select_negeri_dun">Negeri:</label>
                                <select class="custom-select" name="select_negeri_dun" id="select_negeri_dun">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                    @foreach($negeri as $item)                                    
                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="select_parlimen_dun">Parlimen:</label>
                                <select class="custom-select" name="select_parlimen_dun" id="select_parlimen_dun">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih parlimen</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn-save-dun">Simpan</button>
                    <input type="hidden" name="action" id="action_dun" value="add" />
                    <input type="hidden" name="_method" id="method_dun" value="" />
                    <input type="hidden" name="hidden_id" id="hidden_id_dun" />
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalPBT" tabindex="-1" role="dialog" aria-labelledby="ModalPBTLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalPBTLabel">Tambah PBT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="#" id="pbt_form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                            <ul></ul>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="kod_pbt">Kod PBT:</label>
                                <input type="text" class="form-control" placeholder="Taip no id PBT" name="kod_pbt" id="kod_pbt">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_pbt">Nama PBT:</label>
                                <input type="text" class="form-control" placeholder="Taip nama pbt" name="input_pbt" id="input_pbt">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="select_negeri_pbt">Negeri:</label>
                                <select class="custom-select" name="select_negeri_pbt" id="select_negeri_pbt">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                    @foreach($negeri as $item)                                    
                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn-save-pbt">Simpan</button>
                    <input type="hidden" name="action" id="action_pbt" value="add" />
                    <input type="hidden" name="_method" id="method_pbt" value="" />
                    <input type="hidden" name="hidden_id" id="hidden_id_pbt" />
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalBandar" tabindex="-1" role="dialog" aria-labelledby="ModalBandarLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalBandarLabel">Tambah Bandar / Kawasan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="#" id="bandar_form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row clearfix">
                        <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                            <ul></ul>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <small>Isi maklumat pada ruangan di bawah, dan tekan butang <strong>Simpan</strong> untuk menambah rekod ke pangkalan data</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_bandar">Nama Bandar / Kawasan / Tempat:</label>
                                <input type="text" class="form-control" placeholder="Taip nama bandar atau kawasan" name="input_bandar" id="input_bandar">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="select_negeri_bandar">Negeri:</label>
                                <select class="custom-select" name="select_negeri_bandar" id="select_negeri_bandar">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih negeri</option>
                                    @foreach($negeri as $item)                                    
                                    <option value="{{ $item->state_id }}">{{ $item->state_description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                            <label for="select_daerah_bandar">Daerah:</label>
                                <select class="custom-select" name="select_daerah_bandar" id="select_daerah_bandar">
                                    <option value="" disabled selected hidden style="color: #a9a9a9 !important;">- Pilih daerah</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn-save-bandar">Simpan</button>
                    <input type="hidden" name="action" id="action_bandar" value="add" />
                    <input type="hidden" name="_method" id="method_bandar" value="" />
                    <input type="hidden" name="hidden_id" id="hidden_id_bandar" />
                </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<style>    
    #daerah_table_filter, #parlimen_table_filter, #dun_table_filter, #pbt_table_filter, #bandar_table_filter  {
        display: none;
    }

    div.dataTables_processing {
        z-index: 1;
    }
</style>
@stop

@include('js.pengurusan.j-rujukan_data')
