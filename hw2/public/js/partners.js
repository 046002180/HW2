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