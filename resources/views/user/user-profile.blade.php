@extends('layout.master')
@section('parentPageTitle', 'Sistem Maklumat Perpaduan')
@section('title', 'Profil')

@section('content')
<div class="section-body mt-3">
  <div class="container-fluid">
    <div class="row clearfix ">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">KEMASKINI PROFIL</h3>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-lg-6 col-sm-12">
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

@stop

@section('page-script')
<script src="{{ asset('assets/bundles/apexcharts.bundle.js') }}"></script>

<script src="{{ asset('assets/js/core.js') }}"></script>
<script src="{{ asset('assets/js/page/index.js') }}"></script>
@stop
