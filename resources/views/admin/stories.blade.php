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
            <a class="btn btn-primary" href="{{ url('story/create') }}">New Story</a>
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">Authors</th>
                  <th scope="col">Source</th>
                </tr>
              </thead>
              <tbody>
                @foreach($stories as $story)
                <tr> 
                  <td>{{ $story->title}}</td>
                  <td>{{ $story->authors}}</td>
                  <td>{{ $story->squiffy}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
