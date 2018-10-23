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
    @foreach($stories as $story)
        <div class="col-sm-6">
            <div class="card story-card">
                <div class="card-body">
                  <h5 class="card-title">{{ $story->title}}</h5>
                  <p class="card-text">{{ $story->description }}</p>
                  <a class="btn btn-primary" href="{{ url('play/'.$story->id) }}">Start Story</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection