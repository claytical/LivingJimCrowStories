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
            <a class="btn btn-primary float-right mb-3" href="{{ url('admin/vault/create') }}">New Vault Item</a>
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">URL</th>
                  <th scope="col">Category</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $item)
                <tr> 
                  <td><a href="{{ url('vault/'.$item->id.'/edit')}}">{{ $item->title}}</a></td>
                  <td>{{ $item->url}}</td>
                  <td>{{ $item->category}}</td>
                  <td>
                <form action="{{ route('vault.destroy', $item->id)}}" method="post">
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
