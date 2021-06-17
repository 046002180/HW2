function show_menu() {
    let long_menu = document.querySelector("#long-menu");
    long_menu.style.display = "flex";
}

const small_menu = document.querySelector("#small-menu");
small_menu.addEventListener("click", show_menu);

function hide_menu() {
    let long_menu = document.querySelector("#long-menu");
    long_menu.style.display = "none";
}

const lm_button = document.querySelector("#lm-button");
lm_button.addEventListener("click", hide_menu);

function onResponse(response) {
    return response.json();
}
function onError(error) {
    console.log("Errore" + error);
}
function onJson(json) {
    const result = json.response;
    if (result.status !== 'ok') {
        console.log("errore");
        return;
    }
    const news = result.results;
    const news_box = document.querySelector('#news-box');
    news_box.innerHTML = '';
    for (item of news) {
        let text = item.webTitle;
        let url = item.webUrl;
        let a = document.createElement("a");
        a.classList.add("external-news");
        a.textContent = text;
        a.href = url;
        news_box.appendChild(a);

    }
}
function search_news() {
    //VIENE RECUPERATA LA KEYWORD DAL MENU A TENDINA
    const options = document.querySelector("#selection");
    let keyword = options.value;
    const news_header = document.querySelector("#news-header h2");
    //IL TITOLO DELLA SEZIONE NEWS VIENE AGGIORNATA
    news_header.textContent = 'News on ' + keyword;
    keyword = keyword.toLowerCase();
    //SI SOSTITUISCONO I TRATTINI 
    //keyword = keyword.replace("-", "%20");
    const csrf_token=document.querySelector("meta[name='csrf_token']").getAttribute("content");
    const form = new FormData();
    form.append("argument", keyword);
    form.append('_token',csrf_token)
    fetch("home/news", {
        method: "post",
        headers:{
            'X-CSRF-TOKEN': csrf_token
        },
        body: form
    }).then(onResponse, onError).then(onJson);
}
const selection = document.querySelector("#selection");
selection.addEventListener("change", search_news);
search_news();