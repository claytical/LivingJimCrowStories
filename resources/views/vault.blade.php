@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
    @parent
    <!-- additional topnav-->
@endsection

@section('content')
<div class="row">
    <img src="logo.svg" class="img-fluid mx-auto d-block pb-5" alt="Living Jim Crow" style="width: 100% \9";>
</div>

<div class="row">
    @foreach($vault as $item)
        <div class="col-sm-6">
            <div class="card vault-card">
                <div class="card-body">
                  <img src="{{ url('/icons/' . $icons[$item->category] )}}" width=100 class="float-right" />
                  <h5 class="card-title">{{ $item->title}}</h5>
                  <p class="card-text">{{ $item->description }}</p>
                </div>
            </div>
        </div>
    @endforeach
    @foreach($locked as $item)
        <div class="col-sm-6">
            <div class="card vault-card-locked">
                <div class="card-body">
                    <i class="fas fa-lock fa-10x float-right"></i>
                    <h5 class="card-title">{{ $categories[$item->category]}}</h5>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection