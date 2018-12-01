<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="css/favicon.ico">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href="https://unpkg.com/js-offcanvas@1.2.8/dist/_css/prefixed/js-offcanvas.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=IM+Fell+DW+Pica" rel="stylesheet">
        <link rel="stylesheet" href="/css/jim.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <title>@yield('title')</title>
    </head>
    <body>

        @section('topnav')
            <nav class="top">
                <section class="buttons">
                @if (!Auth::check())
                    <a class="btn btn-outline-dark" href="{{ url('redirect/facebook')}}"><i class="fab fa-facebook"></i> Login with Facebook</a>
                @endif

                <a class="" href="{{url('/')}}"><img width="50" src="{{ url('icons/home.png')}}"/></a>
                @if (Auth::check())
                    <a class="m-2" data-toggle="modal" data-target=".vault-modal-lg" href="#" id="vault_link"><img width="50" src="{{ url('icons/vault.png')}}"/></a>
                @endif
                
                @if(\Request::is('play/*'))
                    <a id="restart" href="#" class=""><img width="40" src="{{ url('icons/restart.png')}}"/></a>
                @endif
                </section>

                <img src="{{url('/logo.svg')}}" class="logo" alt="Living Jim Crow"/>

            </nav>
        @show
        <main role="main" class="container jim-container">
            @if(session()->get('success'))
                <div class="alert alert-success">
                  {{ session()->get('success') }}  
                </div><br />
             @endif

            @yield('content')
        </main>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
    <script src="https://unpkg.com/js-offcanvas@1.2.8/dist/_js/js-offcanvas.pkgd.min.js"></script> 
            @yield('scripts')
    </body>
</html>