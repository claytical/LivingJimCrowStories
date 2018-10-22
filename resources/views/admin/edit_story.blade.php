@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <nav class="nav flex-column">
              <a class="nav-link active" href="{{ url('admin/stories') }}">Stories</a>
              <a class="nav-link" href="{{ url('admin/logout') }}">Vault Items</a>
            </nav>
        </div>
        <div class="col-md-9">
          <h1>Edit Story</h1>
          {!! Form::open(['route' => 'story.update']) !!}

            <div class="form-group">
              {!! Form::label('title', 'Title') !!}
              {!! Form::text('title', $story->title, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('authors', 'Authors') !!}
              {!! Form::text('authors', $story->authors, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('description', 'Description') !!}
              {!! Form::textarea('description', $story->description, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
              {{ Form::select('squiffy', $squiffies, $story->squiffy, ['class' => 'form-control']) }}
            </div>
            {!! Form::submit('Update Story', ['class' => 'btn btn-info']) !!}

        {!! Form::close() !!}



        </div>
    </div>
</div>
@endsection
