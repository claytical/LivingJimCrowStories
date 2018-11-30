@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
  <div id="cover">
    <img class="img-fluid" src="going off_cl.png">
  </div>
    @parent
    <!-- additional topnav-->
    <div class="hero">
      <h1 class="display-4 push-50-pct">The Untold Story of Baseball's Desegregation</h1>
      <p class="lead push-25-pct">Jackie Robinson broke baseball’s color line in 1947, but it took another generation of Black and Latino players to make the sport truly open to all. Playing in remote minor-league towns, these 
were the men who, before they could live their big-league dreams, first had to beat Jim Crow.</p>

    </div>
      <div class="polaroids">
          <img src="/bg/polaroid1.png" class="polaroid-1 web mobile img-fluid"/>
          <img src="/bg/polaroid2.png" class="polaroid-2 web img-fluid" />
      </div>

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
  <div class="col-sm-12"><h1 class="text-center">Experience Their Stories</h1></div>
    @foreach($stories as $story)
        <div class="col-sm-4 pt-5">
            <div class="card story-card">
                <div class="card-body">
                  <h5 class="card-title">{{ $story->title}}</h5>
                  <p class="card-text">{{ $story->description }}</p>
                  <a class="btn btn-outline-dark bottom-left-corner" href="{{ url('play/'.$story->id) }}">Play</a>
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
