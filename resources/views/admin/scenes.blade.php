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
            <a class="btn btn-primary float-right mb-3" href="{{ url('admin/scene/create') }}">New Scene</a>
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">Filename</th>
                  <th scope="col">Category</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($scenes as $scene)
                <tr> 
                  <td><a href="{{ url('admin/scene/'.$scene->id.'/edit')}}">{{ $scene->title}}</a></td>
                  <td>{{ $story->filename}}</td>
                  <td>{{ $categories[$scene->category]}}</td>
                  <td>
                <form action="{{ route('scene.destroy', $scene->id)}}" method="post">
                   {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
