@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
    @parent
    <!-- additional topnav-->    
    <aside id="vault">
      <div class="c-offcanvas-content-wrap">
          <a href="#vault" id="vault_trigger" class="vault-header btn btn-dark-outline btn-sm float-right"><i class="fas fa-times"></i></a>
          <a href="{{url('vault')}}" class='vault-header btn btn-md float-right'><i class="fas fa-expand"></i></a>
      </div>

         <h2>Vault</h2>
         
         <div id="vault_content"></div>
    </aside>

@endsection

@section('content')

<div class="row mt-5">
  <div class="col-sm-6 mt-5">
    <h1>{{ $story->title}}</h1>
    <h2>{{ $story->authors}}</h2>
  </div>   
  <div class="col-sm-6" id="alert_area">
    </div>
  </div>
</div>
</div>
<div class="row">
  <div class="col-sm-6">    
      <div id="squiffy"></div>
  </div>
  <div class="col-sm-6" id="scene">    

  </div>
</div>

<div class="modal fade vault-modal-lg" tabindex="-1" role="dialog" aria-labelledby="vaultModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">      
      <div class="modal-body vault-modal" style="">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button><h5 class="modal-title h4" id="vaultModalLabel">Vault</h5>

    <div>Something</div>
      </div>
    </div>
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
/*                $('#vault').offcanvas({
                    modifiers: 'right, overlay', // default options
                    triggerButton: '#vault_link' // btn to open offcanvas
                });
                vault = $('#vault').data('offcanvas-component');          
*/
            });

          

        </script>

@endsection