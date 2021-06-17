<html>

<head>
    <title>SignUp</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/signup.css')}}">
    <script src="{{url('js/signup.js')}}" defer></script>
</head>

<body>
    <h1 id="header">
        <a href="{{url('home')}}" id="logo"></a>
        <nav id="navbar">
            <a class="nav_item" href="{{url('home')}}">HOME</a>
            <a class="nav_item" href="{{url('products')}}">PRODOTTI</a>
            <a class="nav_item" href="{{url('hq')}}">SEDI</a>
            <a class="nav_item" href="{{url('partners')}}">PARTNERS</a>
        </nav>
        <button id="small-menu">
            <img id="3-stripes" src="{{url('img/common/minimenu.png')}}" />
        </button>
    </h1>
    <div id="long-menu">
        <div id="lm-overlay"></div>
        <button id="lm-button">
            <img id="arrows" src="{{url('img/common/arrows.png')}}" />
        </button>
        <div id="lm-box-link">
            <a class="long-menu-link" href="{{url('home')}}">Home</a>
            <a class="long-menu-link" href="{{url('products')}}">Prodotti</a>
            <a class="long-menu-link" href="{{url('hq')}}">Sedi</a>
            <a class="long-menu-link" href="{{url('partners')}}">Partners</a>
        </div>
    </div>
    <main id="general">
        <div id="data-box">
            <h2>Inserisci i dati richiesti</h2>
            @if (isset($error))
            <em class='error'>{{$error}}</em>
            @endif
            <form name="user-data" method="post">
                <input type='hidden' name='_token' value="{{csrf_token()}}">
                <div id="ext-box">
                    <div class="info-box">
                        <p>
                            <label>Nome <input type="text" name="name"></label>
                        </p>
                        <p>
                            <label>Stato <input type="text" name="state"></label>
                        </p>
                        <p>
                            <label>Indirizzo <input type="text" name="address"></label>
                        </p>
                        <p>
                            <label>Email <input type="text" name="email"></label>
                        </p>
                        <p>
                            <label>Password <input type="password" name="password"></label>
                        </p>
                        <p>
                            <label>Conferma password <input type="password" name="password2"></label>
                        </p>
                    </div>
                    <div class="info-box">                        
                        <p>
                            <label>Cognome <input type="text" name="surname"></label>
                        </p>                       
                        <p>
                            <label>Città<input type="text" name="city"></label>
                        </p>                       
                        <p>
                            <label>N. <input type="text" name="number"></label>
                        </p>
                        <p class="advice">
                            <em>Inserisci un'email che usi regolarmente, riceverai lì le</em></br>
                            <em>le nostre comunicazioni.</em></br>
                        </p>
                        <p class="advice">
                            <em>La password deve contenere almeno 8 (max 16) caratteri</em></br>
                            <em>di cui almeno un numero e un carattere speciale (es. @,#,!).</em>
                        </p>
                    </div>
                </div>
                <p>
                    <label id="submit-label"><input type="submit" value="Registrati"></label>
                </p>
            </form>
            <a href="{{url('login')}}">Ho già un account</a>
        </div>
    </main>
    <footer>
        <div id="stripe"></div>
        <div id="footer-box">
            <div id="mini-logo-box">
                <img src="{{url('img/common/minilogo.png')}}" />
                <span id="azienda">Lambda software.spa</span></br>
                <span id="sede">Italy,Rome</span>
            </div>
            <div id="footer-links-box">
                <a class="link" href="chs.html">Chi siamo</a>
                <span class="vertical-stripe">|</span>
                <a class="link" href="lav.html">Lavora con noi</a>
                <span class="vertical-stripe">|</span>
                <a class="link" href="contatti.html">Contatti</a></br>
                <div id="box-social">
                    <a id="instagram-link" class="social-logo" href="insprofile.html"></a>
                    <a id="facebook-link" class="social-logo" href="fbprofile.html"></a>
                    <a id="twitter-link" class="social-logo" href="twprofile.html"></a>
                </div>
                <span id="dati">CARLO PIO PACE Matricola:O46002180</span>
            </div>
        </div>
    </footer>
</body>

</html>