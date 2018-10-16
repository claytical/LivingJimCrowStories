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
{!! Form::open(['route' => 'contact.store']) !!}
    $story->squiffy = "example";

            <div class="form-group">
              {!! Form::label('title', 'Title') !!}
              {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('authors', 'Authors') !!}
              {!! Form::text('authors', null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
              <label for="exampleFormControlSelect1">Example select</label>
              <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
            {!! Form::submit('Create Story', ['class' => 'btn btn-info']) !!}

        {!! Form::close() !!}



        </div>
    </div>
</div>
@endsection
