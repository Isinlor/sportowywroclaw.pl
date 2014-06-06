<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sportowy Wrocław</title>
    <!-- Bootstrap -->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/bootstrap-responsive.css');}}
    {{ HTML::script('http://code.jquery.com/jquery-latest.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}

    {{ HTML::style('css/style.css') }}
    {{-- small trick for URLs in js files --}}
    <script type="text/javascript">
        var BASE = '{{URL::base()}}'+'/';
    </script>
    <base href="<?php echo URL::base().'/index.php/'; ?>" />
</head>
<body>
<div class="container">
    <a href="">{{ HTML::image('img/logo.png', 'logo - sportowywrocław.pl', array('id' => 'logo'));}}</a>
    <div class="navbar navbar-inverse">
        <div class="navbar-inner">
            <ul class="nav">
                <li class="active"><a href="">Strona Główna</a></li>
                <li><a href="view_galleries">Galeria</a></li>
                <li><a href="view_video">Video</a></li>
                <li><a href="#">Zapowiedzi</a></li>
                <li><a href="#">Publicystyka</a></li>
                <li><a href="#">Reklama</a></li>
                <li><a href="#">Kontakt</a></li>
            </ul>
            <ul class="nav pull-right">
                @if ( Auth::guest() )
                <li>{{ HTML::link('login', 'Login') }}</li>
                @else
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin<b class="caret"></b> </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                        <li>{{ HTML::link('new_post', 'Dodaj wpis') }}</li>
                        <li>{{ HTML::link('new_gallery', 'Dodaj galerię') }}</li>
                    </ul>
                </li>
                <li class="divider-vertical"></li>
                <li>{{ HTML::link('logout', 'Logout') }}</li>
                @endif

            </ul>
        </div>
    </div>
    <div class="row">
        <div class="span3">
             <ul class="nav nav-list">
                <li class="nav-header">Sporty Drużynowe</li>
                <li class="active"><a href="view_post/tag/Piłka Nożna">Piłka Nożna</a></li>
                <li><a href="#">Siatkówka</a></li>
                <li><a href="#">Koszykówka</a></li>
                <li><a href="#">Piłka ręczna</a></li>
                <li class="nav-header">Sport Szkolny</li>
                <li><a href="#">Podstawówki</a></li>
                <li><a href="#">Gimnazja</a></li>
                <li><a href="#">Szkoły Średnie</a></li>
                <li><a href="#">Studia / AWF</a></li>
                <li class="nav-header">Lekkoatletyka</li>
                <li><a href="#">Bieganie</a></li>
                <li><a href="#">Skok w dal</a></li>
                <li><a href="#">Trójskok</a></li>
                <li><a href="#">Skok wzwyż</a></li>
                <li><a href="#">Skok o tyczce</a></li>
                <li><a href="#">Rzut oszczepem</a></li>
                <li><a href="#">Wieloboje</a></li>
                <li class="nav-header">Sporty motorowe</li>
                <li><a href="#">Kartingowy</a></li>
                <li><a href="#">Motocyklowy</a></li>
                <li><a href="#">Samochodowy</a></li>
                <li><a href="#">Żużlowy</a></li>
            </ul>
        </div>
        <div class="span6">
                <div class="content">
                    @yield('content')
                 </div>
        </div>
        <div class="span3">
            <h2>Popularne</h2>
            <p>
             <div class="thumbnail">
                <img src="http://lorempixel.com/270/150/sports/1" alt="">
                <h3>News 1</h3>
                <p>Description...</p>
            </div>
            </p>
            <p>
             <div class="thumbnail">
                <img src="http://lorempixel.com/270/150/sports/2" alt="">
                <h3>News 2</h3>
                <p>Description...</p>
            </div>
            </p>
            <p>
            <div class="thumbnail">
                <img src="http://lorempixel.com/270/150/sports/3" alt="">
                <h3>News 3</h3>
                <p>Description...</p>
            </div>
            </p>
        </div>
    </div>
    <hr class="featurette-divider">


      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p>© 2012 Code & Design by Tomasz Darmetko based on <a href="#">Twitter Bootstrap</a> & <a href="#">Laravel Framework</a></p>
      </footer>
</div>
</body>
</html>