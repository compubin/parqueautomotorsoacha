@extends('layouts.app')


@section('content')
<section class="page-header row">
  <h3> Root Area <small> Superadmin  </small></h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Home </a></li>
    <li  class="active"> Core  </li>
  </ol>
</section>
<div class="page-content row">
    <div class="page-content-wrapper no-margin">

<div class="row">
  <div class="col-sm-3">
        <div class="widget btn-primary">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-free-code-camp fa-4x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Crud / Modules </span>
                    <h2 class="font-bold"> Builder </h2>
                </div>
            </div>
        </div>
    </div>

  <div class="col-sm-3">
        <div class="widget btn-info">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-random fa-4x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> RestAPI </span>
                    <h2 class="font-bold">Generator</h2>
                </div>
            </div>
        </div>
    </div>

  <div class="col-sm-3">
        <div class="widget btn-warning">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-database fa-4x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> PHP MyAdmin </span>
                    <h2 class="font-bold"> Database Table</h2>
                </div>
            </div>
        </div>
    </div>

  <div class="col-sm-3">
        <div class="widget btn-success">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-tasks fa-4x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Form </span>
                    <h2 class="font-bold"> Generator </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="widget btn-info">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-cloud-upload fa-4x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Media Management  </span>
                    <h2 class="font-bold"> DropZone </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="widget btn-primary">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-sitemap fa-4x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Menu Management  </span>
                    <h2 class="font-bold"> Site Naviagation </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="widget btn-success">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-code fa-4x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Source Code   </span>
                    <h2 class="font-bold">Editor </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="widget btn-danger">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-archive fa-4x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Users Acitivites   </span>
                    <h2 class="font-bold"> Record Logs  </h2>
                </div>
            </div>
        </div>
    </div>
</div>

       
    </div>
</div>        
@stop