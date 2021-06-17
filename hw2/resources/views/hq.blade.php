<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{url('css/hq.css')}}" />
  <script src="{{url('js/hq.js')}}" defer></script>
  <script src="{{url('js/contents.js')}}" defer></script>
</head>

<body>
  <h1 id="header">
    <a href="{{url('home')}}" id="logo"></a>
    <nav id="navbar">
      <a class="nav_item" href="{{url('home')}}">HOME</a>
      <a class="nav_item" href="{{url('products')}}">PRODOTTI</a>
      <a class="nav_item" href="{{url('partners')}}">PARTNERS</a>
      <a href="{{url('userarea')}}"><img id="nav-icon" src="{{url('img/common/u-icon.png')}}" /></a>
    </nav>
    <button id="small-menu">
      <img id="3-stripes" src="{{url('img/common/minimenu.png')}}" />
    </button>
  </h1>
  <section id="general">
    <div id="long-menu">
      <div id="lm-overlay"></div>
      <button id="lm-button">
        <img id="arrows" src="{{url('img/common/arrows.png')}}" />
      </button>
      <div id="lm-box-link">
        <a class="long-menu-link" href="{{url('home')}}">Home</a>
        <a class="long-menu-link" href="{{url('partners')}}">Partners</a>
        <a class="long-menu-link" href="{{url('products')}}">Prodotti</a>
        <a class='long-menu-link' href="{{url('userarea')}}">Area personale</a>
      </div>
    </div>
    <div id="first-box">
      <div id="map-box">
        <button id="left-arrow" class="arrow">
          <img class="arrow-img" src="{{url('img/sedi/l-arrow.png')}}" />
        </button>
        <div id="variable-map">
          <img id="map-img" src="{{url('img/sedi/map-rome.jpg')}}" />
        </div>
        <button id="right-arrow" class="arrow">
          <img class="arrow-img" src="{{url('img/sedi/r-arrow.png')}}" />
        </button>
      </div>
      <div id="city-image-box">
        <img data-id="city-img" class="external-img" src="/hw2/public/img/sedi/rome.jpg"/>
      </div>
    </div>
    <div id='bottom-box'>
      <div id='description-box'>
        <h2 id='city-name'>Roma</h2>
        <span id='description'>La prima sede dell'azienda,nata nel 2003,proprio nella capitale.È la sede del CDA e
          dei team di sviluppo che sono i primi pioneri di questa azienda.</span>
      </div>
      <img data-id="building-img" class="external-img" src="/hw2/public/img/sedi/romehq.jpg"/>
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