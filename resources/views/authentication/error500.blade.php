@extends('layout.authentication')
@section('title', 'Error 500')


@section('content')
<div class="card">
    <div class="text-center mb-2">
        <a class="header-brand" href="{{route('dashboard.index')}}"><i class="fe fe-command brand-logo"></i></a>
    </div>
    <div class="card-body">
        <div class="display-3 text-muted mb-5"><i class="si si-exclamation"></i> 500</div>
        <h1 class="h3 mb-3">Oops.. You just found an error page..</h1>
        <p class="h6 text-muted font-weight-normal mb-3">We are sorry but your request contains bad syntax and cannot be fulfilled&hellip;</p>
        <a class="btn btn-primary" href="javascript:history.back()"><i class="fe fe-arrow-left mr-2"></i>Go back</a>
    </div>
</div>
@stop
