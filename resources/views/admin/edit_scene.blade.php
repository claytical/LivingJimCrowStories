@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <nav class="nav flex-column">
              <a class="nav-link active" href="{{ url('admin/stories') }}">Stories</a>
              <a class="nav-link" href="{{ url('admin/vault') }}">Vault Items</a>
              <a class="nav-link" href="{{ url('admin/scenes') }}">Scenes</a>

            </nav>
        </div>
        <div class="col-md-9">
          <h1>Edit Scene</h1>
          <form method="post" action="{{ route('scene.update', $scene->id) }}">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="form-group">
              {!! Form::label('title', 'Title') !!}
              {!! Form::text('title', $scene->title, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {{ Form::select('category', $categories, $scene->category, ['class' => 'form-control']) }}
            </div>


            <div class="form-group">
              {{ Form::select('filename', $scenery, $scene->filename, ['class' => 'form-control']) }}
            </div>
            {!! Form::submit('Update Scene', ['class' => 'btn btn-info']) !!}

        {!! Form::close() !!}



        </div>
    </div>
</div>
@endsection
