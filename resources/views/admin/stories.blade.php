@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <nav class="nav flex-column">
              <a class="nav-link active" href="#">Active</a>
              <a class="nav-link" href="#">Link</a>
              <a class="nav-link" href="#">Link</a>
              <a class="nav-link disabled" href="#">Disabled</a>
            </nav>
        </div>
        <div class="col-md-9">
            <table class="table">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">Title</th>
                  <th scope="col">Authors</th>
                  <th scope="col">Source</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Mark</td>
                  <td>Otto</td>
                  <td>@mdo</td>
                </tr>
              </tbody>
            </table>

        </div>
    </div>
</div>
@endsection
