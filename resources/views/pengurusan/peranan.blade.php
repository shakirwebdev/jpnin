@extends('layout.master')
@section('title', 'Pengurusan Peranan')


@section('content')    
    <div class="section-body">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <ul class="nav nav-tabs page-header-tab">
                    <li class="nav-item"><a class="nav-link active" id="Departments-tab" data-toggle="tab" href="#ref-peranan"><i class="fa fa-list-ul"></i>&nbsp;Peranan Pengguna</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" id="Departments-tab2" data-toggle="tab" href="#ref-kebenaran-akses"><i class="fa fa-list-ul"></i>&nbsp;Kebenaran Akses</a></li>
                    <li class="nav-item"><a class="nav-link" id="Departments-tab3" data-toggle="tab" href="#ref-menu"><i class="fa fa-list-ul"></i>&nbsp;Pentadbiran Menu</a></li> -->
                </ul>
            </div>
        </div>
    </div>
    <div class="section-body mt-3">
        <div class="container-fluid">
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="ref-peranan" role="tabpanel">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <label>&nbsp;</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Cari peranan..." id="myInputTextField_Peranan">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>&nbsp;</label>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-sm btn-primary" title="" data-toggle="modal" data-target="#ModalPeranan"><i class="fa fa-window-restore" aria-hidden="true"></i>&nbsp;&nbsp;Tambah Peranan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title text-primary">Senarai peranan</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-vcenter table-hover mb-0" id="peranan_table" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nama Peranan</th>
                                                    <th>Penerangan</th>
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
                <!-- <div class="tab-pane fade" id="ref-kebenaran-akses" role="tabpanel">
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                            <h3 class="card-title text-primary">KEBENARAN AKSES</h3>
                            </div>
                            <div class="card-body">                                
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th><span class="pusing">Laman</span></th>
                                                <th><span class="pusing">ORANG AWAM</span></th>
                                                <th><span class="pusing">PPD</span></th>
                                                <th><span class="pusing">PPN</span></th>
                                                <th><span class="pusing">HQ<br>(RT)</span></th>
                                                <th><span class="pusing">HQ<br>(UKK)</span></th>
                                                <th><span class="pusing">HQ<br>(UPK)</span></th>
                                                <th><span class="pusing">HQ<br>(SRS)</span></th>
                                                <th><span class="pusing">KETUA<br>PENGARAH RT</span></th>
                                                <th><span class="pusing">PENGERUSI</span></th>
                                                <th><span class="pusing">SETIAUSAHA</span></th>
                                                <th><span class="pusing">BENDAHARI</span></th>
                                                <th><span class="pusing">KETUA<br>PERONDA</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Employee</td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" />
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" />
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked=""/>
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked=""/>
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked=""/>
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" />
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked=""/>
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked=""/>
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" />
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked=""/>
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" checked=""/>
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" />
                                                        <span class="custom-control-label">&nbsp;</span>
                                                    </label>
                                                </td>
                                            </tr>                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div> -->

                <!-- <div class="tab-pane fade" id="ref-menu" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">BORANG TINDAKAN</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <span class="tag tag-green mb-1">Senarai menu</span>
                                    <div class="cf nestable-lists">

                                        <div class="dd" id="nestable3">
                                            <ol class="dd-list" id="list_all_available_route">
                                                @php
                                                /*
                                                foreach( Route::getRoutes() as $key => $route){
                                                    $action =  $route->getActionName();
                                                    $prefix = $route->getPrefix();
                                                    $data = $route->uri();
                                                    
                                                    if($action !== 'Closure' && $prefix == '') {
                                                        echo '<li class="dd-item dd3-item" data-id="'.$key.'">';
                                                        echo '    <div class="dd-handle dd3-handle">Drag</div>';
                                                        echo '    <div class="dd3-content">'.$data.'<div style="float:right">';
                                                        echo '    <a href="javascript:void(0);" title="" data-toggle="modal" data-target="#ModalMenuEdit"><i class="fe fe-edit"></i></a></div>';
                                                        echo '    </div>';
                                                        echo '</li>';
                                                    }
                                                } */
                                                @endphp
                                                
                                            </ol>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">MENU UTAMA</h3>
                                    <div class="card-options">
                                        <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">                                    
                                    <span class="text-sm"><small><i>"Drag-and-Drop"</i> menu pada ruangan <b>BORANG TINDAKAN > Senarai Menu</b> ke ruangan disediakan dibawah.<small></span>
                                    <br>
                                    <br>
                                    <span class="tag tag-blue mb-1">Dipaparkan</span>
                                    <div class="cf nestable-lists">

                                        <div class="dd" id="nestable4" style="min-height: 250px; border: solid #ddd 1px; padding: 10px;">
                                            <ol class="dd-list" id="list_done_route">
                                                
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>            
    </div>
@stop

@section('popup')
    <!-- Modal -->
    <div class="modal fade" id="ModalPeranan" tabindex="-1" role="dialog" aria-labelledby="ModalPerananLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalPerananLabel">Tambah Peranan Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="#" id="peranan_form">
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
                                <label for="input_peranan_nama">Nama Peranan:</label>
                                <input type="text" class="form-control" placeholder="Taip nama peranan" name="input_peranan_nama" id="input_peranan_nama">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="input_peranan_penerangan">Penerangan:</label>
                                <textarea class="form-control" placeholder="Keterangan ringkas peranan" name="input_peranan_penerangan" id="input_peranan_penerangan"></textarea>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn-save-peranan">Simpan</button>
                    <input type="hidden" name="action" id="action_peranan" value="add" />
                    <input type="hidden" name="_method" id="method_peranan" value="" />
                    <input type="hidden" name="hidden_id" id="hidden_id_peranan" />
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ModalMenuEdit" tabindex="-1" role="dialog" aria-labelledby="ModalMenuEditLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="#" id="peranan_menu_form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="col-md-12 alert alert-danger error_alert" role="alert" style="display: none; padding-bottom: 0px;">
                        <ul></ul>
                    </div>
                    <div id="msg" class="alert hide"></div>
                    <table id="user" class="table table-bordered table-striped">
                        <tbody>
                            <tr>         
                                <td>URL</td>
                                <td>
                                    <span id="peranan_menu_url">
                                    <input type="hidden" name="url" id="peranan_menu_url_form" value="" />
                                </td>
                            </tr>  
                            <tr>         
                                <td width="15%">Nama</td>
                                <td><a href="#" class="myeditable" id="peranan_menu_nama" data-type="text" data-name="nama"></a></td>
                            </tr>                            
                            <tr>         
                                <td>Ikon</td>
                                <td><a href="#" id="peranan_menu_ikon" class="myeditable" data-type="select" data-name="ikon"></a></td>
                            </tr>     
                            <tr>         
                                <td>Tab?</td>
                                <td><a href="#" id="peranan_menu_tabs" data-type="select" data-value="" data-name="tabs"></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success" id="btn-save-menu">Simpan</button>
                    <input type="hidden" name="action" id="action_peranan_menu" value="add" />
                    <input type="hidden" name="_method" id="method_peranan_menu" value="" />
                    <input type="hidden" name="hidden_id" id="hidden_id_peranan_menu" />
                </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('page-styles')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/datatable/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/nestable/jquery.nestable.min.css') }}">
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>

<style>    
    #peranan_table_filter, #akses_table_filter, #menu_table_filter {
        display: none;
    }

    div.dataTables_processing {
        z-index: 1;
    }
    .pusing {
        display:block;
        -webkit-transform: rotate(-90deg); 
        -moz-transform: rotate(-90deg); 
        filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3); //For IE support
    }
</style>
<link rel="stylesheet" href="{{ asset('css/peranan.css') }}">
@stop

@include('js.pengurusan.j-peranan')
