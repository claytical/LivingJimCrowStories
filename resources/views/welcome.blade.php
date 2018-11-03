@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
    @parent
    <!-- additional topnav-->
@endsection

@section('content')

    <aside id="vault">
      <div class="c-offcanvas-content-wrap">
          <a href="#vault" id="vault_trigger" class="btn btn-dark-outline btn-sm float-right"><i class="far fa-times-circle"></i></a>
      </div>

         <h2>Vault</h2>
         <div id="vault_content"></div>
    </aside>


<div class="row">
    @foreach($stories as $story)
        <div class="col-sm-6">
            <div class="card story-card">
                <div class="card-body">
                  <h5 class="card-title">{{ $story->title}}</h5>
                  <p class="card-text">{{ $story->description }}</p>
                  <a class="btn btn-outline-dark float-right" href="{{ url('play/'.$story->id) }}"><i class="fas fa-play"></i></a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
@section('scripts')
    <script src="/js/vault.js" charset="UTF-8"></script>

    <script>
      var vault;
        $(function($){
          $('#vault').offcanvas({
              modifiers: 'right, overlay', // default options
              triggerButton: '#vault_link' // btn to open offcanvas
          });
          vault = $('#vault').data('offcanvas-component');          

      });

    </script>
@endsection
