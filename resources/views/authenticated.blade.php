@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
    @parent
    <!-- additional topnav-->
@endsection

@section('content')
        @if($service == "facebook")
            Welcome {{ $details->user['name']}}
        @endif
@endsection