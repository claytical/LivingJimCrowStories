@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
    @parent
    <!-- additional topnav-->
@endsection

@section('content')

<div class="row">
  <div class="col-sm-12">
    <h1>{{ $story->title}}</h1>
    <h2>{{ $story->authors}}</h2>
      <div id="squiffy"></div>
  </div>
</div>
@section('scripts')
        <script src="/js/stories/{{ $story->squiffy }}.js" charset="UTF-8"></script>
        <script src="/js/vault.js" charset="UTF-8"></script>

        <script>
            var squif;
            $(function($){
//                $('#vault_button').click(toggleVault);
                squif = $('#squiffy').squiffy();
//                var restart = function () {
//                    $('#squiffy').squiffy('restart');
//                };
//                $('#restart').click(restart);
//                $('#restart').keypress(function (e) {
//                    if (e.which !== 13) return;
//                    restart();
//                });
            });
        </script>

@endsection