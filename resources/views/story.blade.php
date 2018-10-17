@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
    @parent
    <!-- additional topnav-->    
    <aside id="vault">
         <h2>Vault</h2>
         <div id="vault_content"></div>
    </aside>

@endsection

@section('content')

<div class="row">
  <div class="col-sm-12">    
    <a id="restart" href="#" class="float-right btn btn-info">Restart</a>
    <h1>{{ $story->title}}</h1>
    <h2>{{ $story->authors}}</h2>
      <div id="squiffy"></div>
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
                $('#vault').offcanvas({
                    modifiers: 'right, overlay', // default options
                    triggerButton: '#vault_trigger' // btn to open offcanvas
                });
                vault = $('#vault').data('offcanvas-component');          

            });

          

        </script>

@endsection