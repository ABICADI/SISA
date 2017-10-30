@extends('layouts.proceso-empleado')
@section('content')
  <div class="content-wrapper">
    @include('flash::message')
    @yield('action-content')
    <!-- /.content -->
  </div>
@endsection
