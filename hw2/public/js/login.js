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


function validateEmail(email) {
    const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/g;
    return regex.test(email);
}
function validatePassword(password) {
    const regex_n = /[a-zA-Z\.\*\\"!£$%&\/()=?^'§°#@{}\[\]]/g;
    const regex_sp = /[@#§°ç{}\\\|!"£$%&/\(\)\=\?\^]/g;
    if (!(regex_n.test(password)))
        return false;//la password non contiene numeri
    if (!(regex_sp.test(password)))
        return false;//la password non contiene caratteri speciali
    if (password.length < 8 || password.length > 16)
        return false;
    return true;
}
function removeBox(event){
    const box=event.currentTarget.parentNode.parentNode;
    box.remove();
    document.body.classList.remove('no-scroll');
}
function formCheck(event) {
    const form = document.forms['login'];
    if (form.email.value.length === 0 || form.password.value.length === 0) {
        const main=document.querySelector('#general');
        const div=document.createElement('div');
        div.dataset.id='err_box';
        const div2=document.createElement('div');
        div2.dataset.id='c_box';
        const img=document.createElement('img');
        img.classList.add('close_img');
        img.src='/hw2/public/img/common/close.png';
        img.addEventListener('click',removeBox);
        const div3=document.createElement('div');
        div3.dataset.id='err_m_box';
        div3.classList.add('err_message');
        div3.textContent='Compila tutti i campi'
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!validateEmail(form.email.value)) {
        const main=document.querySelector('#general');
        const div=document.createElement('div');
        div.dataset.id='err_box';
        const div2=document.createElement('div');
        div2.dataset.id='c_box';
        const img=document.createElement('img');
        img.classList.add('close_img');
        img.src='/hw2/public/img/common/close.png';
        img.addEventListener('click',removeBox);
        const div3=document.createElement('div');
        div3.dataset.id='err_m_box';
        div3.classList.add('err_message');
        div3.textContent='Email non valida'
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
    if (!validatePassword(form.password.value)) {
        const main=document.querySelector('#general');
        const div=document.createElement('div');
        div.dataset.id='err_box';
        const div2=document.createElement('div');
        div2.dataset.id='c_box';
        const img=document.createElement('img');
        img.classList.add('close_img');
        img.src='/hw2/public/img/common/close.png';
        img.addEventListener('click',removeBox);
        const div3=document.createElement('div');
        div3.dataset.id='err_m_box';
        div3.classList.add('err_message');
        //anche se in un controllo javascript ,la password è errata, in quanto 
        //ha già superato gli stessi controlli nella fase di signup
        div3.textContent = "Password errata";
        document.body.classList.add("no-scroll");
        div.appendChild(div2);
        div2.appendChild(img);
        div.appendChild(div3);
        main.appendChild(div);
        event.preventDefault();
        return;
    }
}
const submit = document.querySelector("#submit-label input");
submit.addEventListener("click", formCheck);
