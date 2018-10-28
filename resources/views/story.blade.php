@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
    @parent
    <!-- additional topnav-->    
    <aside id="vault">
      <div class="c-offcanvas-content-wrap">
          <a href="#vault" id="vault_trigger" class="btn btn-dark-outline btn-sm float-right"><i class="far fa-times-circle"></i></a>
      </div>

         <h2>Vault</h2>
         <a href="{{url('vault')}}" class='btn btn-md float-right'>Expand</a>
         <div id="vault_content"></div>
    </aside>

@endsection

@section('content')

<div class="row">
  <div class="col-sm-12">
    <h1>{{ $story->title}} <a id="restart" href="#" class="float-right btn"><img width="50" src="{{ url('icons/restart.png')}}"/></a></h1>
    <h2>{{ $story->authors}}</h2>
    

  </div>
</div>
<div class="row">
  <div class="col-sm-6">    
      <div id="squiffy"></div>
  </div>
  <div class="col-sm-6" id="scene">    

  </div>
</div>

@endsection

@section('scripts')
        <script src="/js/stories/{{ $story->squiffy }}.js" charset="UTF-8"></script>
        <script src="/js/vault.js" charset="UTF-8"></script>

        <script>
            var squif;
            var vault;
            
            $("#restart").click(function() {
              $("#squiffy").squiffy({
                    restartPrompt: false
                });
              $("#squiffy").squiffy('restart');
            });

            $(function($){
                squif = $('#squiffy').squiffy();
                $('#vault').offcanvas({
                    modifiers: 'right, overlay', // default options
                    triggerButton: '#vault_link' // btn to open offcanvas
                });
                vault = $('#vault').data('offcanvas-component');          

            });

          

        </script>

@endsection