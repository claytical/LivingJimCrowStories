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
      <div class="vault-close">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>      
   </div>
      <div class="modal-body vault-modal">
        <div class="container bottom-vault">
          <div class="row vault-side">
            <div class="col-sm modal-border-side">
            </div>
            <div class="col-sm-2 modal-border-middle">
                <div class="modal-title" id="vaultModalLabel">Vault</div>            
            </div>
            <div class="col-sm modal-border-side">
            </div>
          </div>

          <div class="row vault-side">
              @if($vault)
                @foreach($vault as $category => $items)
                  @foreach($items as $item)
                  <div class="col-sm-4">
                        <div class="vault-card">
                            <div class="vault-body">
                              <img src="/icons/new.png" class="new-vault-item"/>
                              <div class="vault-title">{{ $item['title']}}</div>
                              <p class="vault-text">{{ $item['description'] }}</p>
                              <a href="{{ $item->url }}" class="btn btn-outline-dark">View Source</a>
                              {!! $item['status'] !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                {!! $items->links() !!}
                @endforeach
              @endif
              @if($locked)
                @foreach($locked as $item)
                    <div class="col-sm-4">
                        <div class="vault-card">
                            <div class="vault-body">
                                <img src="/icons/lock.png" class="lock-image"/>
                              {!! $item->status !!}

                            </div>
                        </div>
                    </div>
                @endforeach
              @endif
            </div>
          </div>
          <div class="pager">
          
          <!--
          <nav aria-label="Category Navigation">
            <ul class="pagination justify-content-center">
              <li class="page-item">
                <a class="page-link" href="#" tabindex="-1">&lt;</a>
              </li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#">&gt;</a>
              </li>
            </ul>
          </nav>
          -->
            
          </div>
          <div class="side-tabs">
                  <div class="vault-tab"><a href="#"><img src="/icons/image.png" class="img-fluid"></a></div>
                  <div class="vault-tab"><a href="#"><img src="/icons/newspaper.png" class="img-fluid"></a></div>
                  <div class="vault-tab"><a href="#"><img src="/icons/video.png" class="img-fluid"></a></div>
                  <div class="vault-tab"><a href="#"><img src="/icons/article.png" class="img-fluid"></a></div>
                  <div class="vault-tab"><a href="#"><img src="/icons/greenbook.png" class="img-fluid"></a></div>
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