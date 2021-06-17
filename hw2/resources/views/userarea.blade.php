<html>

<head>
    <title>Area utente</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url('css/userarea.css')}}">
    <script src="{{url('js/userarea.js')}}" defer></script>
</head>

<body data-id="{{session('lambda_user')}}" @if (isset($Password_changed) || isset($error)) class='no-scroll' ; @endif>
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
            <a class="long-menu-link" href="{{url('partners')}}">Partner</a>
        </div>
    </div>
    <main id="general">
        <div id="user-box">
            <div id="left-side-box">
                <span class="option" data-id="purchase">I tuoi acquisti</span>
                <span class="option" data-id="report">Reporta Bug</span>
                <span class="option" data-id="change-password">Cambia password</span>
                <span class="option" data-id="logout">Logout</span>
            </div>
            <form id='cpr-form' data-id='cpr-form' name='cpr-form' class='hidden no-width' method='post'>
            </form>
            <div id="right-side-box" data-id="right-side-box" class='box-width'>
                @if (isset($Password_changed))
                <div id='d-box'>
                    <div id='dbox-b'><img id='dbox-img' src="{{url('img/common/close.png')}}" /></div>
                    <div id='dbox-msg'>
                        @if ($Password_changed) Password aggiornata correttamente
                        @else Errore: password non aggiornata
                    </div>
                </div>
                @endif
                @endif
                @if (session('Reported')!==null)
                <div id='d-box'>
                    <div id='dbox-b'><img id='dbox-img' src="{{url('img/common/close.png')}}" /></div>
                    <div id='dbox-msg'>
                        @if (session('Reported')) Report correttamente registrato, grazie della segnalazione
                        @else Errore: Report non registrato
                    </div>
                </div>
                @endif
                @endif
                @if (isset($error))
                <div id='d-box'>
                    <div id='dbox-b'><img id='dbox-img' src="{{url('img/common/close.png')}}" /></div>
                    <div id='dbox-msg'>{{$error}}</div>
                </div>
                @endif
                <!-- I contenuti vanno aggiunti dinamicamente tramite javascript in questo box -->
            </div>
        </div>
    </main>
</body>

</html>