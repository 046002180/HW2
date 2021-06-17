

function show_menu() {
    const long_menu = document.querySelector("#long-menu");
    show(long_menu);
    long_menu.classList.add("flex");
}

const small_menu = document.querySelector("#small-menu");
small_menu.addEventListener("click", show_menu);

function hide_menu() {
    const long_menu = document.querySelector("#long-menu");
    long_menu.classList.remove("flex");
    hide(long_menu);
}

const lm_button = document.querySelector("#lm-button");
lm_button.addEventListener("click", hide_menu);

function show_cartSlide() {
    const Slide = document.querySelector("#cart-slide");
    show(Slide);
    Slide.classList.add("flex");
}


const carts = document.querySelectorAll(".cart");
for (cart of carts)
    cart.addEventListener("click", show_cartSlide);

function hide_cartSlide() {
    const Slide = document.querySelector("#cart-slide");
    Slide.classList.remove("flex");
    hide(Slide);
}

const cs_button = document.querySelector("#back-button");
cs_button.addEventListener("click", hide_cartSlide);

function show_products(event) {
    const arrow = event.currentTarget;
    arrow.src = "/hw2/public/img/prodotti/up-arrow.png";

    for (content of List_content[arrow.parentNode.dataset.group]) {
        let line = document.createElement('span');
        line.classList.add("temp_line");
        line.textContent = content;
        line.addEventListener("click", searchProduct);
        line.addEventListener("click", add_resetSpan);
        arrow.parentNode.appendChild(line);
    }

    arrow.removeEventListener("click", show_products);
    arrow.addEventListener("click", remove_products);
}
function remove_products(event) {
    const up_arrow = event.currentTarget;
    up_arrow.src = "/hw2/public/img/prodotti/down-arrow.png";

    const node_list = up_arrow.parentNode.querySelectorAll(".temp_line");
    for (node of node_list) {
        node.remove();
    }

    up_arrow.removeEventListener("click", remove_products);
    up_arrow.addEventListener("click", show_products);
}

const arrows = document.querySelectorAll(".product-group .arrow");
for (arrow of arrows)
    arrow.addEventListener("click", show_products);


function show_description(event) {
    const down_arrow = event.currentTarget;
    down_arrow.src = "/hw2/public/img/prodotti/up-arrow.png";

    const str = down_arrow.parentNode.querySelector("h3").textContent;
    const new_description = document.createElement("span");
    new_description.textContent = List_descriptions[str];
    new_description.classList.add("tmp_dsr");
    down_arrow.parentNode.appendChild(new_description);

    down_arrow.removeEventListener("click", show_description);
    down_arrow.addEventListener("click", remove_description);
}

function remove_description(event) {
    const up_arrow = event.currentTarget;
    up_arrow.src = "/hw2/public/img/prodotti/down-arrow.png";

    const description = up_arrow.parentNode.querySelector(".tmp_dsr");
    description.remove();

    up_arrow.removeEventListener("click", remove_description);
    up_arrow.addEventListener("click", show_description);
}
const product_arrows = document.querySelectorAll(".product .arrow");
for (arrow of product_arrows)
    arrow.addEventListener("click", show_description);

function add_toCart(event) {
    const product = event.currentTarget;
    const str = product.parentNode.querySelector("h3").textContent;//prende il nome del prodotto dall'intestazione
    const cart = document.querySelector("#cart-box");//seleziona il box adibito a contenere le miniature
    if (alredyExistsInCart(cart, str)) { //controlla che non esista già la miniatura
        showMessage(1);
        return;//se la miniatura già esiste mostra un messaggio
    }
    const new_div = document.createElement('div');//crea il box che conterrà la miniatura e il nome
    const img_x = document.createElement('img');//immagine della x che permette di togliere il prodotto dal carrello
    img_x.src = "/hw2/public/img/prodotti/close.png";
    img_x.classList.add("close-x");
    img_x.addEventListener("click", remove_fromCart);
    const img = document.createElement('img');//miniatura
    img.src = "/hw2/public/img/prodotti/" + img_names[str];//path + estensione miniatura definita nel file content.js
    const new_span = document.createElement('span');
    new_span.textContent = str;
    const input = document.createElement("input");
    input.type = 'hidden';
    input.name = 'list[]';
    input.value = str.toLowerCase();
    new_div.appendChild(img_x);
    new_div.appendChild(img);
    new_div.appendChild(new_span);
    new_div.appendChild(input);
    new_div.classList.add("small-product");
    cart.appendChild(new_div);
    refresh_subtotal(str, 1);
}
function remove_fromCart(event) {
    const product = event.currentTarget;
    const str = product.parentNode.querySelector("span").textContent;
    product.parentNode.remove();
    refresh_subtotal(str, 2);
}
function alredyExistsInCart(cart, string) {
    const items = cart.querySelectorAll(".small-product span");
    for (item of items)
        if (item.textContent === string)
            return true;
    return false;
}
function showMessage(i) {
    const body = document.querySelector("body");
    const overlay = document.createElement("div");
    overlay.dataset.id = "overlay";
    const box = document.createElement("div");
    box.dataset.id = "box-message";
    const imgBox=document.createElement("div");
    imgBox.dataset.id="ov-img-box";
    const img = document.createElement("img");
    img.src = "/hw2/public/img/prodotti/close.png"
    img.classList.add("close-img");
    img.addEventListener("click", close_message);
    const message = document.createElement("div");
    message.dataset.id="message";
    if (i === 1)
        message.textContent = "Sarà possibile selezionare più di una copia per prodotto nella pagina carrello.";
    else
        message.textContent = "Carrello vuoto";
    body.appendChild(overlay);
    overlay.appendChild(box);
    box.appendChild(imgBox);
    box.appendChild(message);
    imgBox.appendChild(img);
    document.body.classList.add("no-scroll");
}

function close_message(event) {
    document.body.classList.remove("no-scroll");
    const overlay = document.querySelector("div[data-id='overlay']");
    console.log(overlay);
    overlay.remove();
}

const add_sign = document.querySelectorAll(".add-img");
for (item of add_sign)
    item.addEventListener("click", add_toCart);

function refresh_subtotal(index, mode) {
    /*mode 1 sum,mode 2 subtraction*/
    const subtotal = document.querySelector("#subtotale");
    if (subtotal.textContent === '' && mode === 1) {
        //mostra il carrello quando si aggiunge il primo prodotto
        show(subtotal);
        subtotal.textContent = "Subtotale : " + prices[index].toString() + " €";
        show_cartSlide();
    } else {
        let x = subtotal.textContent.substr(12);//rimuove "Subtotale : "
        x = x.substr(0, x.length - 2);//rimuove " €"
        x = parseFloat(x);
        if (mode === 1)
            x += prices[index];
        else
            x -= prices[index];
        x = x.toFixed(2);//arrotondamento a 2 cifre decimali
        subtotal.textContent = "Subtotale : " + x.toString() + " €";
    }

    if (subtotal.textContent.substr(12) === '0.00 €') {
        subtotal.textContent = '';
        subtotal.classList.add("hidden");
        hide_cartSlide();
    }
}

function searchProduct(event) {
    const target = event.currentTarget;
    const str = target.textContent;
    const rows = document.querySelectorAll(".row");
    for (row of rows) {
        let items = row.querySelectorAll(".product");
        for (item of items) {
            if (item.querySelector("h3").textContent === str) {
                if (item.classList.contains("hidden"))
                    show(item);
                continue;
            }
            hide(item);
        }
    }
}
function add_resetSpan() {
    if ((document.querySelector(".reset-button") !== null))
        return;//il bottone ripristina esiste già
    const new_span = document.createElement("span");
    new_span.textContent = "Ripristina vista";
    new_span.classList.add("reset-button");
    list.appendChild(new_span);
    new_span.addEventListener("click", reset_ProductBox);
}
function reset_ProductBox(event) {
    const reset_button = event.currentTarget;
    const products = document.querySelectorAll(".product");
    for (product of products)
        show(product);
    reset_button.remove();
}

function searchString(event) {
    const searchBar = event.currentTarget;
    const str = searchBar.value.toLowerCase();
    const items = document.querySelectorAll(".product");
    for (item of items) {
        if (item.querySelector("h3").textContent.toLowerCase().slice(0, str.length) === str) {
            if (item.classList.contains("hidden"))
                show(item);
            continue;
        }
        hide(item);
    }
}


const search_bar = document.querySelector("#search-bar");
search_bar.addEventListener("keyup", searchString);


function emptyCartCheck(event) {
    //controlla che sia presente almeno un prodotto nel carrello
    const item = document.querySelector(".small-product");
    if (item === null) {
        event.preventDefault();
        showMessage(2);
    }
}
const input_cart = document.querySelector("#cart-input");
input_cart.addEventListener("click", emptyCartCheck);

function show(x) {
    x.classList.remove("hidden");
}
function hide(x) {
    x.classList.add("hidden");
}


