@extends('layout')

@section('content')

    Welcome, {{ Auth::getUser()->name }}
    
    <img src="{{url('assets/images/logo.jpeg')}}" style="display: block;margin: 30px auto;" />
@endsection

@section('custom_js')

@endsection