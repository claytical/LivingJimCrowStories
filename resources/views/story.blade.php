@extends('layouts.app')

@section('title', 'Living Jim Crow')

@section('topnav')
    @parent
    <!-- additional topnav-->    

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
      <div class="vault-close float-right">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>      
   </div>
      <div class="modal-body vault-modal">
        <div class="container bottom-vault">
          <div class="row vault-side">
            <div class="col-sm modal-border-side">
            </div>
            <div class="col-sm modal-border-middle">
                <div class="modal-title" id="vaultModalLabel">Vault</div>            
            </div>
            <div class="col-sm modal-border-side">
            </div>
          </div>

          <div class="row vault-side">
              @if($vault)
                @foreach($vault as $item)
                  <div class="col-sm-4">
                        <div class="vault-card">
                            <div class="vault-body">
                              <div class="vault-title">{{ $item->title}}</div>
                              <p class="vault-text">{{ $item->description }}</p>
                              <a href="{{ $item->url }}" class="btn btn-outline-dark">View Source</a>
                            </div>
                        </div>
                    </div>
                @endforeach
              @endif
              @if($locked)
                @foreach($locked as $item)
                    <div class="col-sm-4">
                        <div class="vault-card">
                            <div class="vault-body">
                                <img src="/icons/lock.png" class="lock-image img-fluid"/>
                            </div>
                        </div>
                    </div>
                @endforeach
              @endif
            </div>
          </div>
        </div>
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