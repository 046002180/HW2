function checkPasswordSp(password) {
    //controlla che la password contenga caratteri speciali
    const regex_sp = /[@#§°ç{}\\\|!"£$%&/\(\)\=\?\^]/g;
    return regex_sp.test(password);
}
function checkPasswordNum(password) {
    //controlla che la password contenga numeri
    const regex_num = /[0-9]/g;
    return regex_num.test(password);
}
function removeBox2(event) {
    const box = event.currentTarget.parentNode.parentNode;
    box.remove();
    document.body.classList.remove("no-scroll");
}

function formCheck(event) {
    const form = document.forms['cpr-form'];
    if (form.current_password.value.length === 0 || form.new_password.value.length === 0 || form.new_password2.value.length === 0) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Compila tutti i campi del form";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "/hw2/public/img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (form.new_password.value.length !== form.new_password2.value.length ||
        form.new_password.value !== form.new_password2.value) {
        //Le password non coincidono
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Le password inserite non coincidono";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "/hw2/public/img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;

    }
    if (form.current_password.value.length < 8 || form.current_password.value.length > 16
        || !checkPasswordSp(form.current_password.value) || !checkPasswordSp(form.current_password.value)) {
        //La password corrente è errata ha già passato i controlli nella fase di signup 
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Password errata";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "/hw2/public/img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (form.new_password.value.length < 8) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Password inserita troppo corta";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "/hw2/public/img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (form.new_password.value.length > 16) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Password inserita troppo lunga";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "/hw2/public/img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (!checkPasswordNum(form.new_password.value)) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "La password non contiene numeri";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "/hw2/public/img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (!checkPasswordSp(form.new_password.value)) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "La password non contiene caratteri speciali";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "/hw2/public/img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
}



function showChangePasswordView() {
    const box = document.querySelector("#right-side-box");
    box.classList.remove('box-width');
    box.classList.add('no-width');
    box.classList.add('hidden');
    box.innerHTML = "";
    const form = document.querySelector('#cpr-form');
    form.innerHTML = '';
    form.classList.add('form-width');
    form.classList.remove('no-width');
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = '_token';
    hidden.value = document.querySelector("meta[name='csrf_token']").getAttribute("content");
    form.appendChild(hidden);
    for (let i = 0; i < 3; i++) {
        const p = document.createElement("p");
        const label = document.createElement("label");
        const input = document.createElement("input");
        input.type = "password";
        input.classList.add("cp-input");
        label.classList.add("cp-label");
        if (i === 0) {
            label.textContent = "Password attuale";
            input.setAttribute("name", "current_password");
        }
        if (i === 1) {
            const div = document.createElement("div");
            div.dataset.id = "cp-message";
            div.textContent = "La password deve contenere almeno 8 (max 16) caratteri di cui almeno un numero e un carattere speciale (es. @,#,!).";
            form.appendChild(div);
            label.textContent = "Nuova password";
            input.setAttribute("name", "new_password");
        }
        if (i === 2) {
            label.textContent = "Conferma nuova password";
            input.setAttribute("name", "new_password2");
        }
        label.appendChild(input);
        p.appendChild(label);
        form.appendChild(p);
    }
    const submit = document.createElement("input");
    submit.dataset.id = "cp-submit";
    submit.type = "submit";
    submit.value = "Cambia password";
    submit.addEventListener("click", formCheck);
    form.appendChild(submit);
    form.classList.remove('hidden');
}
function showDetails(event) {
    const span = event.currentTarget;
    const div = span.parentNode.querySelector(".details-div");
    div.classList.remove("hidden");
    span.innerHTML = "";
    span.textContent = "Riduci";
    span.removeEventListener("click", showDetails);
    span.addEventListener("click", hideDetails);
}
function hideDetails(event) {
    const span = event.currentTarget;
    const div = span.parentNode.querySelector(".details-div");
    div.classList.add("hidden");
    span.innerHTML = "";
    span.textContent = "Dettagli";
    span.removeEventListener("click", hideDetails);
    span.addEventListener("click", showDetails);
}
let page = 0;
let mode = 1;
function changeOrder(event) {
    mode = parseInt(event.currentTarget.value);
    transactionsPage();
}
function showPage(event) {
    page = parseInt(event.currentTarget.textContent) - 1;
    transactionsPage();
}
function transactionsPage() {
    const box = document.querySelector("#right-side-box");
    const content = document.querySelectorAll(".dinamyc-box");
    const pb = document.querySelector(".dyn-box");
    if (pb !== null)
        pb.remove();
    if (content !== null)
        for (item of content)
            item.remove();
    let p1 = 0;
    let p2 = 0;
    if (mode === 1) {
        p1 = (data.length - (3 * page)) - 1;
        p2 = p1 - 3 > 0 ? p1 - 3 : -1;
        if (data.length === 1) {
            p1 = 0;
            p2 = -1;
        }
        for (let i = p1; i > p2; i--) {
            const div = document.createElement("div");
            div.classList.add("dinamyc-box");
            const cbox = document.createElement("div");
            cbox.classList.add("content-box");
            const div2 = document.createElement("div");
            div2.classList.add("data-box-standard");
            const div3 = document.createElement("div");
            div3.classList.add("data-box");
            const span = document.createElement("span");
            span.classList.add("click-span");
            span.textContent = "Dettagli";
            span.addEventListener("click", showDetails);
            const spanId = document.createElement("span");
            spanId.textContent = "Id transazione :";
            spanId.classList.add("data-span");
            const spanData = document.createElement("span");
            spanData.classList.add("data-span");
            spanData.textContent = "Data :";
            const spanTot = document.createElement("span");
            spanTot.classList.add("data-span");
            spanTot.textContent = "Totale pagato :";
            const spanM = document.createElement("span");
            spanM.classList.add("data-span");
            spanM.textContent = "Metodo pagamento :";
            const spanNM = document.createElement("span");
            spanNM.classList.add("data-span");
            spanNM.textContent = "N.Met. pagamento :";
            const spand = document.createElement("span");
            spand.classList.add("data-span");
            spand.textContent = data[i].Id;
            const spand2 = document.createElement("span");
            spand2.classList.add("data-span");
            spand2.textContent = data[i].Data;
            const spand3 = document.createElement("span");
            spand3.classList.add("data-span");
            spand3.textContent = data[i].Importo + "€";
            const spand4 = document.createElement("span");
            spand4.classList.add("data-span");
            spand4.textContent = data[i].Metodo;
            const spand5 = document.createElement("span");
            spand5.classList.add("data-span");
            spand5.textContent = data[i]["Num.Metodo"];
            const hdiv = document.createElement("div");
            hdiv.classList.add("details-div");
            hdiv.classList.add("hidden");
            div2.appendChild(spanId);
            div2.appendChild(spanData);
            div2.appendChild(spanTot);
            div2.appendChild(spanM);
            div2.appendChild(spanNM);
            div3.appendChild(spand);
            div3.appendChild(spand2);
            div3.appendChild(spand3);
            div3.appendChild(spand4);
            div3.appendChild(spand5);
            cbox.appendChild(div2);
            cbox.appendChild(div3);
            div.appendChild(cbox);
            div.appendChild(span);
            div.appendChild(hdiv);
            const products = data[i].Prodotti;
            if (Array.isArray(products))
                for (let i = 0; i < products.length; i++) {
                    const string = products[i];
                    const d = string.split(",");
                    const spanp = document.createElement("span");
                    spanp.classList.add("span-p");
                    spanp.textContent = d[0] + " : " + d[1];
                    hdiv.appendChild(spanp);
                }
            else {
                const string = products;
                const d = string.split(",");
                const spanp = document.createElement("span");
                spanp.classList.add("span-p");
                spanp.textContent = d[0] + " : " + d[1];
                hdiv.appendChild(spanp);
            }
            box.appendChild(div);
        }
        const pageBox = document.createElement('div');
        pageBox.dataset.id = 'page-box';
        pageBox.classList.add('dyn-box');
        const pageSpan = document.createElement('span');
        pageSpan.dataset.id = 'page-span';
        pageSpan.textContent = 'Pagina :';
        pageBox.appendChild(pageSpan);
        const n = Math.ceil(data.length / 3);
        for (let i = 0; i < n; i++) {
            const span = document.createElement('span');
            span.textContent = i + 1;
            span.classList.add('page-number');
            if (i === page)
                span.classList.add("underlined");
            span.addEventListener('click', showPage);
            pageBox.appendChild(span);
        }
        box.appendChild(pageBox);
    }
    if (mode === 2) {
        p1 = page * 3;
        if ((data.length) - p1 >= 3)
            p2 = p1 + 3;
        else
            p2 = data.length
        if (data.length === 1) {
            p2 = 1;
            p1 = 0;
        }
        for (let i = p1; i < p2; i++) {
            const div = document.createElement("div");
            div.classList.add("dinamyc-box");
            const cbox = document.createElement("div");
            cbox.classList.add("content-box");
            const div2 = document.createElement("div");
            div2.classList.add("data-box-standard");
            const div3 = document.createElement("div");
            div3.classList.add("data-box");
            const span = document.createElement("span");
            span.classList.add("click-span");
            span.textContent = "Dettagli";
            span.addEventListener("click", showDetails);
            const spanId = document.createElement("span");
            spanId.textContent = "Id transazione :";
            spanId.classList.add("data-span");
            const spanData = document.createElement("span");
            spanData.classList.add("data-span");
            spanData.textContent = "Data :";
            const spanTot = document.createElement("span");
            spanTot.classList.add("data-span");
            spanTot.textContent = "Totale pagato :";
            const spanM = document.createElement("span");
            spanM.classList.add("data-span");
            spanM.textContent = "Metodo pagamento :";
            const spanNM = document.createElement("span");
            spanNM.classList.add("data-span");
            spanNM.textContent = "N.Met. pagamento :";
            const spand = document.createElement("span");
            spand.classList.add("data-span");
            spand.textContent = data[i].Id;
            const spand2 = document.createElement("span");
            spand2.classList.add("data-span");
            spand2.textContent = data[i].Data;
            const spand3 = document.createElement("span");
            spand3.classList.add("data-span");
            spand3.textContent = data[i].Importo + "€";
            const spand4 = document.createElement("span");
            spand4.classList.add("data-span");
            spand4.textContent = data[i].Metodo;
            const spand5 = document.createElement("span");
            spand5.classList.add("data-span");
            spand5.textContent = data[i]["Num.Metodo"];
            const hdiv = document.createElement("div");
            hdiv.classList.add("details-div");
            hdiv.classList.add("hidden");
            div2.appendChild(spanId);
            div2.appendChild(spanData);
            div2.appendChild(spanTot);
            div2.appendChild(spanM);
            div2.appendChild(spanNM);
            div3.appendChild(spand);
            div3.appendChild(spand2);
            div3.appendChild(spand3);
            div3.appendChild(spand4);
            div3.appendChild(spand5);
            cbox.appendChild(div2);
            cbox.appendChild(div3);
            div.appendChild(cbox);
            div.appendChild(span);
            div.appendChild(hdiv);
            const products = data[i].Prodotti;
            if (Array.isArray(products))
                for (let i = 0; i < products.length; i++) {
                    const string = products[i];
                    const d = string.split(",");
                    const spanp = document.createElement("span");
                    spanp.classList.add("span-p");
                    spanp.textContent = d[0] + " : " + d[1];
                    hdiv.appendChild(spanp);
                }
            else {
                const string = products;
                const d = string.split(",");
                const spanp = document.createElement("span");
                spanp.classList.add("span-p");
                spanp.textContent = d[0] + " : " + d[1];
                hdiv.appendChild(spanp);
            }
            box.appendChild(div);
        }
        const pageBox = document.createElement('div');
        pageBox.dataset.id = 'page-box';
        pageBox.classList.add('dyn-box');
        const pageSpan = document.createElement('span');
        pageSpan.dataset.id = 'page-span';
        pageSpan.textContent = 'Pagina :';
        pageBox.appendChild(pageSpan);
        const n = Math.ceil(data.length / 3);
        for (let i = 0; i < n; i++) {
            const span = document.createElement('span');
            span.textContent = i + 1;
            span.classList.add('page-number');
            if (i === page)
                span.classList.add("underlined");
            span.addEventListener('click', showPage);
            pageBox.appendChild(span);
        }
        box.appendChild(pageBox);
    }
}
function showPurchasesView() {
    const form = document.querySelector('#cpr-form');
    form.classList.remove('form-width');
    form.classList.add('no-width');
    form.classList.add('hidden');
    const box = document.querySelector("#right-side-box");
    box.classList.remove('hidden');
    box.classList.remove('no-width');
    box.classList.add('box-width');
    const dbox = document.querySelector("#d-box");
    if (dbox !== null)
        return;
    box.innerHTML = "";
    if (("error" in data)) {
        //L'utente non ha effettuato acquisti
        const div = document.createElement("div");
        div.dataset.id = "ntr-box";
        const message = document.createElement("span");
        message.dataset.id = "No-transaction-message-p";
        message.textContent = "Non hai ancora effettuato alcuna transazione";
        div.appendChild(message);
        box.appendChild(div);
        return;
    }
    const label = document.createElement('label');
    label.textContent = 'Ordina per data: ';
    label.dataset.id = 'order-label';
    const selectBox = document.createElement('div');
    selectBox.dataset.id = 'select-box';
    const select = document.createElement('select');
    select.classList.add('select-order');
    select.addEventListener('change', changeOrder);
    const option = document.createElement('option');
    option.textContent = 'Decrescente';
    option.value = '1';
    select.appendChild(option);
    const option2 = document.createElement('option');
    option2.textContent = 'Crescente';
    option2.value = '2';
    select.appendChild(option2);
    label.appendChild(select);
    selectBox.appendChild(label);
    box.appendChild(selectBox);
    transactionsPage();
}
function resume(event) {
    const box = event.currentTarget.parentNode.parentNode.parentNode;
    box.classList.add("hidden");
    document.body.classList.remove("no-scroll");
}
function showLogoutConfirm() {
    const a = document.querySelector(".lbox");
    if (a === null) {
        //il box non esiste
        const ext_box = document.createElement("div");
        ext_box.classList.add("lbox");
        const box = document.createElement("div");
        box.dataset.id = "logout-box";
        const img_box = document.createElement("div");
        img_box.dataset.id = "log-subbox";
        const img = document.createElement("img");
        img.src = "/hw2/public/img/common/close.png";
        img.dataset.id = "logout-img";
        img.addEventListener("click", resume);
        const message = document.createElement("div");
        message.dataset.id = "logout-message";
        message.textContent = "Verrai disconnesso dal tuo account,vuoi procedere comunque?";
        const a = document.createElement("a");
        a.textContent = "Procedi";
        a.href = "logout";
        a.dataset.id = "logout-link";
        box.appendChild(img_box);
        img_box.appendChild(img);
        box.appendChild(message);
        box.appendChild(a);
        ext_box.appendChild(box);
        document.body.appendChild(ext_box);
    }
    else {
        //il box già esiste
        a.classList.remove("hidden");
        document.body.classList.add("no-scroll");
    }
}
function descriptionCheck(event) {
    const form = document.forms['cpr-form'];
    if (form.description.value.length === 0) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Descrivi il bug riscontrato";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "/hw2/public/img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
    if (form.description.value.length < 75) {
        event.preventDefault();
        const div = document.createElement("div");
        div.dataset.id = "e-box";
        const div2 = document.createElement("div");
        div2.dataset.id = "e-box-i";
        const div3 = document.createElement("div");
        div3.dataset.id = "e-box-m";
        div3.textContent = "Descrivi il problema dettagliatamente";
        const img = document.createElement("img");
        img.dataset.id = "e-box-img";
        img.src = "/hw2/public/img/common/close.png";
        img.addEventListener("click", removeBox2);
        document.body.classList.add("no-scroll");
        div2.appendChild(img);
        div.appendChild(div2);
        div.appendChild(div3);
        document.body.appendChild(div);
        return;
    }
}
let buyedSoftware = [];

function fillBuyedSoftware() {
    let splitted = [];
    let list = [];
    for (let i = 0; i < data.length; i++) {
        list.push(data[i].Prodotti);
    }
    for (let i = 0; i < list.length; i++) {
        const x = list[i];
        for (let a = 0; a < x.length; a++) {
            const item = x[a].split(",");
            splitted.push(item[0].toLowerCase());
        }
    }
    buyedSoftware = splitted.filter((v, i) => splitted.indexOf(v) === i);
}
function showReportView() {
    const box = document.querySelector("#right-side-box");
    box.innerHTML = "";
    const form = document.querySelector('#cpr-form');
    form.innerHTML = '';
    if (("error" in data)) {
        //L'utente non ha effettuato acquisti
        box.classList.remove('hidden');
        box.classList.remove('no-width');
        box.classList.add('box-width');
        form.classList.remove('form-width');
        form.classList.add('no-width');
        form.classList.add('hidden');
        const div = document.createElement("div");
        div.dataset.id = "ntr-box";
        const message = document.createElement("span");
        message.dataset.class = "No-transaction-message-r";
        message.textContent = "Non possiedi ancora nessuno dei nostri software,quindi";
        const message2 = document.createElement("span");
        message2.dataset.class = "No-transaction-message-r";
        message2.textContent = "non puoi segnalare un bug su un software che non possiedi.";
        div.appendChild(message);
        div.appendChild(message2);
        box.appendChild(div);
        return;
    }
    box.classList.remove('box-width');
    box.classList.add('no-width');
    box.classList.add('hidden');
    form.classList.add('form-width');
    form.classList.remove('no-width');
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = '_token';
    hidden.value = document.querySelector("meta[name='csrf_token']").getAttribute("content");
    form.appendChild(hidden);
    for (let i = 0; i < 2; i++) {
        const p = document.createElement("p");
        p.classList.add('r-p');
        const label = document.createElement("label");
        if (i === 0) {
            label.textContent = "Software :";
            const select = document.createElement('select')
            select.name = 'software';
            select.dataset.id = 'r-select';
            select.setAttribute('name', 'software');
            for (let i = 0; i < buyedSoftware.length; i++) {
                const option = document.createElement('option');
                option.value = buyedSoftware[i];
                option.textContent = buyedSoftware[i];
                select.appendChild(option);
            }
            label.appendChild(select)
            p.appendChild(label);
        }
        if (i === 1) {
            label.textContent = 'Descrizione :';
            const description = document.createElement('textarea');
            description.setAttribute('name', 'description');
            description.setAttribute('cols', '70');
            description.setAttribute('rows', '7');
            description.setAttribute('maxlength', '350');
            description.dataset.id = 'r-description';
            label.appendChild(description);
            p.dataset.id = 'p-description';
            p.appendChild(label);
        }
        form.appendChild(p);
    }
    const submit = document.createElement("input");
    submit.dataset.id = "r-submit";
    submit.type = "submit";
    submit.value = "Invia report";
    submit.formAction = 'userarea/bugReport';
    submit.addEventListener("click", descriptionCheck);
    form.appendChild(submit);
    form.classList.remove('hidden');
}
const spans = document.querySelectorAll(".option");
for (span of spans) {
    if (span.dataset.id === "purchase")
        span.addEventListener("click", showPurchasesView);
    if (span.dataset.id === "change-password")
        span.addEventListener("click", showChangePasswordView);
    if (span.dataset.id === "logout")
        span.addEventListener("click", showLogoutConfirm);
    if (span.dataset.id === "report")
        span.addEventListener("click", showReportView);
}
//Variabile che contiene le informazioni sulle transazioni per non doverle richiedere più di una volta
let data;
function onResponse(response) {
    return response.json();
}
function onError(error) {
    return console.log(error);
}
function getData(json) {
    data = json;
    showPurchasesView();
    fillBuyedSoftware();
}
const user = document.body.dataset.id;
const csrf_token = document.querySelector("meta[name='csrf_token']").getAttribute("content");
const formdata = new FormData();
formdata.append("user", user);
formdata.append("_token", csrf_token);
fetch("userarea/transactions", {
    method: 'post',
    headers: {
        'X-CSRF-TOKEN': csrf_token
    },
    body: formdata
}).then(onResponse, onError).then(getData);

function removeBox(event) {
    const box = event.currentTarget.parentNode.parentNode;
    box.remove();
    showChangePasswordView();
    document.body.classList.remove("no-scroll");
}
const close = document.querySelector("#dbox-img");
if (close !== null) {
    close.addEventListener("click", removeBox);
}


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
