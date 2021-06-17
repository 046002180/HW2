<!DOCTYPE html>
<html>

<head>
  <title>LAMBDA Software home</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name='csrf_token' content='{{csrf_token()}}'>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{url('css/home.css')}}" />
  <script src="{{url('js/home.js')}}" defer></script>
</head>


<body>
  <h1 id="header">
    <div id="overlay"></div>
    <a href="{{url('home')}}" id="logo"></a>
    <nav id="navbar">
      <a class="nav_item" href="{{url('products')}}">PRODOTTI</a>
      <a class="nav_item" href="{{url('hq')}}">SEDI</a>
      <a class="nav_item" href="{{url('partners')}}">PARTNERS</a>
      <a href="{{url('userarea')}}"><img id="nav-icon" src="{{url('img/common/u-icon.png')}}" /></a>
    </nav>
    <button id="small-menu">
      <img id="3-stripes" src="{{url('img/common/minimenu.png')}}" />
    </button>
  </h1>
  <div id="long-menu">
    <div id="lm-overlay"></div>
    <button id="lm-button">
      <img id="arrows" src="img/common/arrows.png" />
    </button>
    <div id="lm-box-link">
      <a class="long-menu-link" href="{{url('products')}}">Prodotti</a>
      <a class="long-menu-link" href="{{url('hq')}}">Sedi</a>
      <a class="long-menu-link" href="{{url('partners')}}">Partners</a>
      <a class='long-menu-link' href="{{url('userarea')}}">Area personale</a>
    </div>
  </div>
  <section id="general">
    <div id="overlay-gen"></div>
    <div id="d1" class="news">
      <div class="image-container">
        <img src="{{url('img/home/icon1.png')}}" />
      </div>
      <div class="intra-section">
        <h3 class="int">V.I.A.D.</h3></br>
        <em>Un antivirus che ha ricevuto più di 300 premi e ad oggi protegge più di 200.000.000 di dispositivi in tutto
          il mondo.</em></br>
        <a class="button" href="{{url('products')}}">Scaricalo ora </a>
      </div>
    </div>
    <div id="d2" class="news">
      <div class="image-container">
        <img src="{{url('img/home/icon2.jpg')}}" />
      </div>
      <div class="intra-section">
        <h3 class="int">PHOTOEDIT</h3></br>
        <em>Crea,edita,modifica,disegna, ogni tua idea può diventare realtà con il nostro editor fotografico.
        </em><br />
        <a class="button" href="{{url('products')}}">Scopri di più </a>
      </div>
    </div>
    <div id="d3" class="news">
      <div class="image-container">
        <img src="{{url('img/home/icon3.jpg')}}" />
      </div>
      <div class="intra-section">
        <h3 class="int">EASYOFFICE</h3></br>
        <em>Easy office è tutto il necessario per creare documenti di ogni tipo,testi,grafici,fogli di
          calcolo...</em></br>
        <em>uno dei nostri prodotti più apprezzati.</em></br>
        <a class="button" href="{{url('products')}}">Visualizza offerte </a>
      </div>
    </div>
    <div id="api-box">
      <div id="news-header">
        <h2>News on Cyber-Attacks</h2>
        <select name="news-selection" id="selection">
          <option value="Cyber-Attack" selected>Cyber-Attacks</option>
          <option value="Cyber-Security">Cyber-Security</option>
          <option value="Data-Breach">Data-Breach</option>
        </select>
      </div>
      <div id="news-box"></div>
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