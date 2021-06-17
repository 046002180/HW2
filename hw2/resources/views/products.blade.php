<html>

<head>
  <title>LAMBDA Software Products</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{url('css/products.css')}}" />
  <script src="{{url('js/products.js')}}" defer></script>
  <script src="{{url('js/contents.js')}}" defer></script>
</head>

<body>
  <h1 id="header">
    <div id="overlay"></div>
    <a href="{{url('home')}}" id="logo"></a>
    <nav id="navbar">
      <a class="nav_item" href="{{url('home')}}">HOME</a>
      <a class="nav_item" href="{{url('hq')}}">SEDI</a>
      <a class="nav_item" href="{{url('partners')}}">PARTNERS</a>
      <a href="{{url('userarea')}}"><img id="nav-icon" src="{{url('img/common/u-icon.png')}}" /></a>
      <button class="cart">
        <img src="{{url('img/prodotti/cart.png')}}" />
      </button>
    </nav>
    <div id="button-box">
      <button id="small-menu">
        <img id="3-stripes" src="{{url('img/common/minimenu.png')}}" />
      </button>
      <button class="cart" id="cart2">
        <img src="{{url('img/prodotti/cart.png')}}" />
      </button>
    </div>
  </h1>
  <div id="long-menu" class="hidden">
    <div id="lm-overlay"></div>
    <button id="lm-button">
      <img src="{{url('img/common/arrows.png')}}" />
    </button>
    <div id="lm-box-link">
      <a class="long-menu-link" href="{{url('home')}}">Home</a>
      <a class="long-menu-link" href="{{url('hq')}}">Sedi</a>
      <a class="long-menu-link" href="{{url('partners')}}">Partners</a>
      <a class="long-menu-link" href="{{url('userarea')}}">Area personale</a>
    </div>
  </div>
  <div id="cart-slide" class="hidden">
    <div id="cart-top">
      <button id="back-button">
        <img src="{{url('img/common/arrows.png')}}" />
      </button>
      <div id="subtotale" class="hidden"></div>
    </div>
    <form method='post'>
    <input type='hidden' name='_token' value="{{csrf_token()}}">
      <div id="cart-box"></div>
      <div id="submit-box">
        <input type="submit" value='Vai al Carrello' id='cart-input'>
      </div>
    </form>
  </div>
  <section id="general">
    <div id="box">
      <div id="list">
        <input id="search-bar" type="text" />
        <div class="product-group" data-group="Antivirus">
          <span class="product-name-type">Antivirus</span>
          <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}">
        </div>
        <div class="product-group" data-group="Elaborazione">
          <span class="product-name-type">Elaborazione Immagini/Video</span>
          <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}">
        </div>
        <div class="product-group" data-group="Professionali">
          <span class="product-name-type">Professionali</span>
          <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}">
        </div>
        <div class="product-group" data-group="Speciali">
          <span class="product-name-type">Speciali</span>
          <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}">
        </div>
        <div class="product-group" data-group="Ufficio">
          <span class="product-name-type">Ufficio</span>
          <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}">
        </div>
      </div>
      <div id="products-box">
        <div class="row">
          <div class="product">
            <h3>AeroLAB</h3>
            <img class="product-img" src="{{url('img/prodotti/aero.png')}}" /></br>
            <span class="prezzo">5000€</span>
            <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}" />
            <img class="add-img" src="{{url('img/prodotti/plus.png')}}" /></br>
          </div>
          <div class="product">
            <h3>EasyOffice</h3>
            <img class="product-img" src="{{url('img/prodotti/eo.jpg')}}"></br>
            <span class="prezzo">100€</span>
            <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}" />
            <img class="add-img" src="{{url('img/prodotti/plus.png')}}" /></br>
          </div>
          <div class="product">
            <h3>Galileo</h3>
            <img class="product-img" src="{{url('img/prodotti/gl.png')}}" /></br>
            <span class="prezzo">249.99€</span>
            <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}" />
            <img class="add-img" src="{{url('img/prodotti/plus.png')}}" /></br>
          </div>
          <div class="product">
            <h3>M.A.C.K.</h3>
            <img class="product-img" src="{{url('img/prodotti/mach.jpg')}}" /></br>
            <span class="prezzo">*</span>
            <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}" /></br>
          </div>
        </div>
        <div class="row">
          <div class="product">
            <h3>PhotoEdit</h3>
            <img class="product-img" src="{{url('img/prodotti/pe.jpg')}}" /></br>
            <span class="prezzo">29.99€</span>
            <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}" />
            <img class="add-img" src="{{url('img/prodotti/plus.png')}}" /></br>
          </div>
          <div class="product">
            <h3>S.C.C.</h3>
            <img class="product-img" src="{{url('img/prodotti/scc.png')}}" /></br>
            <span class="prezzo">*</span>
            <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}" /></br>
          </div>
          <div class="product">
            <h3>V.I.A.D.</h3>
            <img class="product-img" src="{{url('img/prodotti/viad.png')}}" /></br>
            <span class="prezzo">129.99€</span>
            <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}" />
            <img class="add-img" src="{{url('img/prodotti/plus.png')}}" /></br>
          </div>
          <div class="product">
            <h3>VideoEdit</h3>
            <img class="product-img" src="{{url('img/prodotti/ve.jpg')}}" /></br>
            <span class="prezzo">49.99€</span>
            <img class="arrow" src="{{url('img/prodotti/down-arrow.png')}}" />
            <img class="add-img" src="{{url('img/prodotti/plus.png')}}" /></br>
          </div>
        </div>
      </div>
    </div>
  </section>
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