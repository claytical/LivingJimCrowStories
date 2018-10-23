@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
    @parent
    <!-- additional topnav-->
@endsection

@section('content')
<div class="row">
    <img src="logo.svg" class="img-fluid mx-auto d-block" alt="Living Jim Crow" style="width: 100% \9";>
</div>

<div class="row">
    @foreach($vault as $item)
        <div class="col-sm-6">
            <div class="card story-card">
                <div class="card-body">
                  <p class="card-text">{{ print_r($item) }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection