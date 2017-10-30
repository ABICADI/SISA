@extends('layouts.app-template')
@section('content')
  <div class="content-wrapper">
    @include('flash::message')
    @yield('action-content')
    <!-- /.content -->
  </div>
@endsection
