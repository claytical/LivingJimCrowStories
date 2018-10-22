@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <nav class="nav flex-column">
              <a class="nav-link active" href="{{ url('admin/stories') }}">Stories</a>
              <a class="nav-link" href="{{ url('admin/vault') }}">Vault Items</a>
            </nav>
        </div>
        <div class="col-md-9">
          <h1>New Item</h1>
          {!! Form::open(['route' => 'vault.store']) !!}

            <div class="form-group">
              {!! Form::label('title', 'Title') !!}
              {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('url`', 'URL') !!}
              {!! Form::text('url', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('description', 'Description') !!}
              {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
              {{ Form::select('category', $categories, null, ['class' => 'form-control']) }}
            </div>
            {!! Form::submit('Create Item', ['class' => 'btn btn-info']) !!}

        {!! Form::close() !!}



        </div>
    </div>
</div>
@endsection
