<div class="modal fade" id="modal_view_kad_ahli_krt" tabindex="-1" role="dialog" aria-labelledby="ModalJPNINLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalJPNINLabel">Paparan Kad Keahlian E-RIDRT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-md-12">
                         <div class="section-body mt-3">
                            <div class="container-fluid">
                                <div class="tab-content mt-3">
                                    <div class="tab-pane fade show active" id="Departments-list" role="tabpanel">
                                        <div class="card">
                                            <div class="card-body">
                                                Dalam proses pembangunan
                                            </div>
                                        </div>
                                    </div>                
                                </div>
                            </div>            
                        </div>     
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <form  id="form_mvkak1" action="{{ route('pdf.kad_keahlian') }}" target="_blank">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Cetak Kad Keahlian E-IDRT SRS</button>
                </form>
            </div>
        </div>
    </div>
</div>