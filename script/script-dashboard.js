// ---------------------------------------------------------------
// Dashboard
// ---------------------------------------------------------------


// Minimizar Barra de Navegeacion Lateral
let boton = document.querySelector("#menu");
let barra = document.querySelector(".nav_lateral");

boton.onclick = function(){
  barra.classList.toggle("activa");
}

// Menu de Opciones
let boton2 = document.querySelector(".parte3");
let opciones = document.querySelector(".menu_opciones");

boton2.onclick = function(){
  opciones.classList.toggle("abrir");
}

// Mantener Seleccionada una Seccion
let secciones = document.querySelectorAll(".seccion");

secciones.forEach(seccion =>{
  seccion.addEventListener('click', function(){
    secciones.forEach(btn => btn.classList.remove('seleccionado'));
    this.classList.add('seleccionado');
  })
})

