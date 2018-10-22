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
          <h1>Edit Item</h1>
          <form method="post" action="{{ route('vault.update', $item->id) }}">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="form-group">
              {!! Form::label('title', 'Title') !!}
              {!! Form::text('title', $item->title, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('url', 'URL') !!}
              {!! Form::text('url', $item->url, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
              {!! Form::label('description', 'Description') !!}
              {!! Form::textarea('description', $item->description, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
              {{ Form::select('category', $categories, $item->category, ['class' => 'form-control']) }}
            </div>
            {!! Form::submit('Update Item', ['class' => 'btn btn-info']) !!}

        {!! Form::close() !!}



        </div>
    </div>
</div>
@endsection
