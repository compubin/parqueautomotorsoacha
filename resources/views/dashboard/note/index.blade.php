@extends('layouts.app')

@section('content')
<section class="page-header row">
  <h3> My Notes  </h3>
  <ol class="breadcrumb">
    <li><a href="{{ url('dashboard')}}"> Dashboard </a></li>
    <li><a href="{{ url('dashboard')}}"> My Account  </a></li>
    <li  class="active"> Private Note  </li>
  </ol>
</section>
<div class="page-content row">
  <div class="page-content-wrapper no-margin">
      {!! $output !!}
  </div>    
</div>


@stop