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



//VARIABILE GLOBALE CHE PERMETTE DI GESTIRE IL CAMBIO DELLE IMMAGINI
let city_index = 0;

function change_view(index) {
       const map = document.querySelector("#map-img");
       const images = document.querySelectorAll(".external-img");
       const city_name = document.querySelector("#city-name");
       const description = document.querySelector("#description");
       city_name.innerHtml = '';
       description.innerHtml = '';
       switch (index % 4) {
              case 0:
                     //CAMBIA L'IMMAGINE DELLA MAPPA
                     map.src = img_path.rome_map;
                     for (img of images) {
                            //CAMBIA L'IMMAGINE DELLA CITTÀ E DELLA SEDE
                            if (img.dataset.id === 'city-img')
                                   img.src = img_path.rome;
                            if (img.dataset.id === 'building-img')
                                   img.src = img_path.rome_hq;
                     }
                     city_name.textContent = 'Roma';
                     description.textContent = headquarters_description.rome;
                     break;
              case 1:
                     map.src = img_path.houston_map;
                     for (img of images) {
                            if (img.dataset.id === 'city-img')
                                   img.src = img_path.houston;
                            if (img.dataset.id === 'building-img')
                                   img.src = img_path.houston_hq;
                     }
                     city_name.textContent = 'Houston';
                     description.textContent = headquarters_description.houston;
                     break;
              case 2:
                     map.src = img_path.moscow_map;
                     for (img of images) {
                            if (img.dataset.id === 'city-img')
                                   img.src = img_path.moscow;
                            if (img.dataset.id === 'building-img')
                                   img.src = img_path.moscow_hq;
                     }
                     city_name.textContent = 'Mosca';
                     description.textContent = headquarters_description.moscow;
                     break;
              case 3:
                     map.src = img_path.prague_map;
                     for (img of images) {
                            if (img.dataset.id === 'city-img')
                                   img.src = img_path.prague;
                            if (img.dataset.id === 'building-img')
                                   img.src = img_path.prague_hq;
                     }
                     city_name.textContent = 'Praga';
                     description.textContent = headquarters_description.prague;
                     break;
       }



}

function next_view() {
       city_index++;
       change_view(city_index);
}
const right_arrow = document.querySelector("#right-arrow");
right_arrow.addEventListener("click", next_view);

function previous_view() {
       city_index--;
       if (city_index < 0)
              city_index = 3;
       change_view(city_index);
}
const left_arrow = document.querySelector("#left-arrow");
left_arrow.addEventListener("click", previous_view);
