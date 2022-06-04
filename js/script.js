let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');
// al hacer click sobre el botón de menú se activa este menú y se desactiva el menu del perfil de usuario
document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}
// al hacer click sobre el botón de menú se activa este menú y se desactiva el menu de navegación
document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}
// al hacer scroll se cierran los menus
window.onscroll = () =>{
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

