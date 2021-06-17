<html>

<head>
    <title>Carrello</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/cart.css')}}">
    <script src="{{url('js/cart.js')}}" defer></script>
</head>

<body <?php if (isset($transaction)) {
            echo "class='no-scroll'";
        } ?>>
    <h1 id="header">
        <a href="{{url('home')}}" id="logo"></a>
        <nav id="navbar">
            <a class="nav_item" href="{{url('home')}}">HOME</a>
            <a class="nav_item" href="{{url('products')}}">PRODOTTI</a>
            <a class="nav_item" href="{{url('hq')}}">SEDI</a>
            <a class="nav_item" href="{{url('partners')}}">PARTNERS</a>
            <a href="userarea.php"><img id="nav-icon" src="{{url('img/common/u-icon.png')}}" /></a>
        </nav>
        <button id="small-menu">
            <img id="3-stripes" src="{{url('img/common/minimenu.png')}}" />
        </button>
    </h1>
    <div id="long-menu" class='hidden'>
        <div id="lm-overlay"></div>
        <button id="lm-button">
            <img id="arrows" src="{{url('img/common/arrows.png')}}" />
        </button>
        <div id="lm-box-link">
            <a class="long-menu-link" href="{{url('home')}}">Home</a>
            <a class="long-menu-link" href="{{url('products')}}">Prodotti</a>
            <a class="long-menu-link" href="{{url('hq')}}">Sedi</a>
            <a class="long-menu-link" href="{{url('partners')}}">Partner</a>
            <a class="long-menu-link" href="{{url('userarea')}}">Area Personale</a>
        </div>
    </div>
    <main id="general">
        @if(isset($transaction))
        <div id='t-box'>
            @if($transaction)
            <div id='t-message'>Transazione effettuata</div>
            @else
            <div id='t-message'>Transazione non avvenuta</div>
            @endif
            <a id='t-link' href="{{url('userarea')}}">Ritorna all'area utente</a>
        </div>
        @endif
        <div id="err_box" class="hidden">
            <div id="eb_f"><img src="img/common/close.png" id="close-img" /></div>
            <div id="eb_message"></div>
        </div>
        </div>
        <div id="cart-box">
            <form method='post' id="form-box">
                @if (isset($arr_error['form_error']))
                <span class='error-message-f'>{{$arr_error['form_error']}}</span>
                @endif
                <input type='hidden' name='_token' value="{{csrf_token()}}">
                <div id="products-box" class="box">
                </div>
                <div id="payment-data-box" class="box">
                    @if (isset($arr_error['ivv_error']))
                    <span class='error-message'>{{$arr_error['ivv_error']}}</span>
                    @endif
                    <label id="payment-method">Metodo di pagamento <select name="metodo_pagamento">
                            <option selected>Carta di credito</option>
                            <option>Carta prepagata</option>
                        </select>
                    </label>
                    <h2>Dati Intestatario</h2>
                    @if (isset($arr_error['name_error']))
                    <span class='error-message'>{{$arr_error['name_error']}}</span>
                    @endif
                    <p class='label-p'>
                        <label>Nome <input type="text" name="nome"></label>
                    </p>
                    @if (isset($arr_error['surname_error']))
                    <span class='error-message'>{{$arr_error['surname_error']}}</span>
                    @endif
                    <p class='label-p'>
                        <label>Cognome <input type="text" name="cognome"></label>
                    </p>
                    @if (isset($arr_error['num_error']))
                    <span class='error-message'>{{$arr_error['num_error']}}</span>
                    @endif
                    <p class='label-p'>
                        <label>Numero Carta <input type="text" name="numero_metpagamento"></label>
                    </p>
                    @if (isset($arr_error['code_error']))
                    <span class='error-message'>{{$arr_error['code_error']}}</span>
                    @endif
                    <p class='label-p'>
                        <label>CVV/CVC <input type="text" name="codice"></label>
                    </p>
                </div>
                <div id="price-box">
                    <span class="pbox-item">Totale:</span>
                </div>
                <div id="submit-box" class="box">
                    <label><input id="submit-input" type="submit" value="Paga"></label>
                </div>
            </form>
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