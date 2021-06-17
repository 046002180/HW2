function check_paymentMethod(value) {
    if (!value.localeCompare("Carta di credito") || !value.localeCompare("Carta prepagata"))
        return false;
}
function isCharString(string) {
    const regex = /[0-9\.\*\\"!£$%&\/()=?^'§°#@{}\[\]]/g;
    return !(regex.test(string));
}
function isNumber(number) {
    const regex = /[a-zA-Z\.\*\\"!£$%&\/()=?^'§°#@{}\[\]]/g;
    return !regex.test(number);
}
function formCheck(event) {
    const form = document.querySelector("#form-box");
    if (form.metodo_pagamento.value === 0 || form.nome.value.length === 0 || form.cognome.value.length === 0 ||
        form.numero_metpagamento.value.length === 0 || form.codice.value.length === 0) {
        const message = document.querySelector("#eb_message");
        const div = message.parentNode;
        div.classList.remove("hidden");
        document.body.classList.add("no-scroll");
        message.textContent = "Compila tutti i campi del form";
        event.preventDefault();
        return;
    }
    if (!isCharString(form.nome.value)) {
        const message = document.querySelector("#eb_message");
        const div = message.parentNode;
        div.classList.remove("hidden");
        document.body.classList.add("no-scroll");
        message.textContent = "Campo nome non valido";
        event.preventDefault();
        return;
    }
    if (!isCharString(form.cognome.value)) {
        const message = document.querySelector("#eb_message");
        const div = message.parentNode;
        div.classList.remove("hidden");
        document.body.classList.add("no-scroll");
        message.textContent = "Campo cognome non valido";
        event.preventDefault();
        return;
    }
    if (!isNumber(form.numero_metpagamento.value)) {
        const message = document.querySelector("#eb_message");
        const div = message.parentNode;
        div.classList.remove("hidden");
        document.body.classList.add("no-scroll");
        message.textContent = "Metodo pagamento non valido";
        event.preventDefault();
        return;

    }
    if (!isNumber(form.codice.value) || form.codice.value.length !== 3) {
        const message = document.querySelector("#eb_message");
        const div = message.parentNode;
        div.classList.remove("hidden");
        document.body.classList.add("no-scroll");
        message.textContent = "CVV/CVC non valido";
        event.preventDefault();
        return;
    }
}
const form = document.querySelector("#submit-input");
form.addEventListener("click", formCheck);

function readCookie() {
    const regex = /\b[^,+:A-Z ]+/g;
    const cookies = document.cookie.split(";");
    const length = cookies.length;
    for (let i = 0; i < length; i++) {
        const tmp = cookies[i].split("=");
        if (tmp[0].indexOf('cartcookie')!==-1) {
            let value = tmp[1];
            value = decodeURIComponent(value);
            const products = value.match(regex);
            return products;
        }
    }
} 
function destroyCartCookie(){
    //funzione chiamata quando si svuota il carrello/*
    let exp_date="09/08/1943,19:43:00";
    exp_date=new Date(exp_date).toGMTString();
    document.cookie="cartcookie=;path=/;expires="+exp_date+";";
}
//variabile per gestire l'aggiornamento del totale
let cart_list = new Object();
function refreshTotal(event) {
    const n = event.currentTarget.value;
    const product = event.currentTarget.parentNode.parentNode.parentNode.dataset.id;
    const items = document.querySelectorAll(".pbox-item");
    for (item of items) {
        if (item.dataset.id === 'Price') {
            let value = parseFloat(item.textContent.replace("€", ""));
            let a = n - cart_list[product];
            cart_list[product] = n;
            value += products_info[product].Prezzo * a;
            value=value.toFixed(2);
            item.textContent = value + "€";
        }
    }
}
function showEmptyCartMessage(){
    const message = document.querySelector("#eb_message");
    const div = message.parentNode;
    const close=div.querySelector('#eb_f');
    close.remove();
    destroyCartCookie();
    div.classList.remove("hidden");
    document.body.classList.add("no-scroll");
    message.textContent = "Il tuo carrello è vuoto";
    const a=document.createElement("a");
    a.dataset.id="empty-cart-link";
    a.textContent="Torna allo store";
    a.href="products";
    div.appendChild(a);
}
function removeProduct(event) {
    const product = event.currentTarget.parentNode.parentNode;
    const price = parseFloat(products_info[product.dataset.id].Prezzo);
    const items = document.querySelectorAll(".pbox-item");
    for (item of items) {
        if (item.dataset.id === "Price") {
            let value = parseFloat(item.textContent.replace("€", ""));
            value -= price;
            if(value===0){
                //Carrello vuoto
                showEmptyCartMessage()
            }

            value = value.toFixed(2);
            item.textContent = value + "€";
        }
    }
    product.remove();
}
function showProducts() {
    const products = readCookie();
    const box = document.querySelector("#products-box");
    const pbox = document.querySelector("#price-box");
    const tot_span = document.createElement("span");
    tot_span.classList.add("pbox-item");
    tot_span.dataset.id = "Price";
    let tot = 0;
    for (product of products) {
        cart_list[product] = 1;//variabile usata in refreshTotal
        const Price = products_info[product].Prezzo;
        tot += parseFloat(Price);
        const path = products_info[product].Img;
        const sbox = document.createElement("div");
        sbox.classList.add("sub-box");
        sbox.dataset.id = product;
        const img = document.createElement("img");
        img.classList.add("product-img");
        img.src = path;
        const span = document.createElement("span");
        span.textContent = "Prezzo : " + Price + "€";
        span.classList.add("price");
        const ldiv = document.createElement("div");
        ldiv.classList.add("label-div");
        const label = document.createElement("label");
        label.textContent = "N. ";
        label.classList.add("product-number");
        const select = document.createElement("select");
        const attr_val = "numero_copie["+product+"]";
        select.setAttribute("name", attr_val);
        select.addEventListener("change", refreshTotal);
        const trashcan = document.createElement("img");
        trashcan.src = "/hw2/public/img/cart/delete.png";
        trashcan.classList.add("trash");
        trashcan.addEventListener("click", removeProduct);
        for (let i = 1; i <= 10; i++) {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = i;
            select.appendChild(option);
        }
        select.selectedIndex = "0";
        label.appendChild(select);
        ldiv.appendChild(label);
        ldiv.appendChild(trashcan);
        sbox.appendChild(img);
        sbox.appendChild(span);
        sbox.appendChild(ldiv);
        box.appendChild(sbox);
    }
    tot = tot.toFixed(2);
    tot_span.textContent = tot + "€";
    pbox.appendChild(tot_span);
}
let products_info;
function onError(error) {
    return console.log(error);
}
function onResponse(response) {
    return response.json();
}
function onJson(json) {
    products_info = json;
    showProducts();
}

fetch('products/info').then(onResponse, onError).then(onJson);

function hideErrorBox(event) {
    const box = event.currentTarget.parentNode.parentNode;
    box.classList.add("hidden");
    document.body.classList.remove("no-scroll");
}

const close = document.querySelector("#close-img");
close.addEventListener("click", hideErrorBox)

function show_menu() {
    let long_menu = document.querySelector("#long-menu");
    long_menu.classList.add('flex');
    long_menu.classList.remove('hidden');
}

const small_menu = document.querySelector("#small-menu");
small_menu.addEventListener("click", show_menu);

function hide_menu() {
    let long_menu = document.querySelector("#long-menu");
    long_menu.classList.add('hidden');
    long_menu.classList.remove('flex');
}

const lm_button = document.querySelector("#lm-button");
lm_button.addEventListener("click", hide_menu);

