<!DOCTYPE html>
<html>

<head>
    <title>Partners</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/partners.css')}}">
    <script src="{{url('js/partners.js')}}" defer></script>
</head>

<body>
    <h1 id="header">
        <a href="{{url('home')}}" id="logo"></a>
        <nav id="navbar">
            <a class="nav_item" href="{{url('home')}}">HOME</a>
            <a class="nav_item" href="{{url('products')}}">PRODOTTI</a>
            <a class="nav_item" href="{{url('hq')}}">SEDI</a>
            <a href="{{url('userarea')}}"><img id="nav-icon" src="{{url('img/common/u-icon.png')}}" /></a>
        </nav>
        <button id="small-menu">
            <img id="3-stripes" src="{{url('img/common/minimenu.png')}}" />
        </button>
    </h1>
    <div id="long-menu">
        <button id="lm-button">
            <img id="arrows" src="{{url('img/common/arrows.png')}}" />
        </button>
        <div id="lm-box-link">
            <a class="long-menu-link" href="{{url('home')}}">Home</a>
            <a class="long-menu-link" href="{{url('products')}}">Prodotti</a>
            <a class="long-menu-link" href="{{url('nq')}}">Sedi</a>
            <a class='long-menu-link' href="{{url('userarea')}}">Area personale</a>
        </div>
    </div>
    <div id="general">
        <div class="partner-box">
            <img class="partner-img" src="{{url('img/partner/cd.png')}}" />
            <div class="partner-description">
                <h2 class="partner-name">Cyber Defense s.p.a.</h2>
                <span class="description">Protagonista nel campo della cyber-sicurezza, ci affianca ormai da diversi anni, fornendo preziosa expertise sia per i nostri prodotti che per la sicurezza informatica delle nostre infrastrutture.</span>
            </div>
        </div>
        <div class="partner-box">
            <img class="partner-img" src="{{url('img/partner/elt.jpg')}}" />
            <div class="partner-description">
                <h2 class="partner-name">Elettronica s.p.a.</h2>
                <span class="description">Società cardine nel settore tecnologico , più volte abbiamo collaborato per sviluppare ed implementare soluzioni che sono state usate sia nel settore civile che in quello militare.</span>
            </div>
        </div>
        <div class="partner-box">
            <img class="partner-img" src="{{url('img/partner/se.png')}}" />
            <div class="partner-description">
                <h2 class="partner-name">Space Engineering l.t.d.</h2>
                <span class="description">Partner fondamentale per lo sviluppo del nostro software AeroLab, una realtà affermata nel settore aerospaziale.</span>
            </div>
        </div>
        <div class="partner-box">
            <img class="partner-img" src="{{url('img/partner/ess.png')}}" />
            <div class="partner-description">
                <h2 class="partner-name">E.S.S. l.t.d.</h2>
                <span class="description">La collaborazione con questa azienda è nata con lo sviluppo del software S.C.C. , e dura tutt'ora. Insieme abbiamo sviluppato soluzioni tecnologiche per varie agenzie spaziali.</span>
            </div>
        </div>
    </div>
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