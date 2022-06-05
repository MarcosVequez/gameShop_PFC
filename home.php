<?php

include './components/connect.php';

session_start();
// Si hay sesión iniciada guardo en $user_id al usuario con sesión iniciada, si el usuario es admin lo redirijo al dashboard de admin
// guardando al usuario en $admin_id
// si no lo dejo vacio
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}elseif(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    header('location:admin/dashboard.php'); 
}
else{
   $user_id = '';
};

//incluyo el componente wishlist_cart

include './components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>gameShop</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">


   <link rel="stylesheet" href="css/style.css">

</head>
<body>
 <!-- Incluyo el componente header -->  
<?php include './components/web_header.php'; ?>

<div class="home-bg">

<!--Slider de la página principal -->
<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="imagenes/Xbox_fh5_01.jpg" alt="Juego Forza Horizon 5">
         </div>
         <div class="content">
            <span>Juegos de videoconsola</span>
            <h3>últimas novedades</h3>
            <a href="shop.php" class="btn">compra ahora</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="imagenes/Play_ratchetclank03.jpg" alt="Consola play">
         </div>
         <div class="content">
            <span>Videoconsolas</span>
            <h3>Disfruta la nueva generación</h3>
            <a href="shop.php" class="btn">compra ahora</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="imagenes/mando_Xbox_Azul02.jpg" alt="Mando Xbox">
         </div>
         <div class="content">
            <span>Periféricos</span>
            <h3>Mandos, auriculares ...</h3>
            <a href="shop.php" class="btn">compra ahora</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>
</section>

</div>
<!-- Slider de tarjetas de categorias -->
<section class="category">
   <!-- Incluyo el component category-slider  -->
   <?php include './components/category_slider.php'; ?>

</section>

<section class="home-products products">

   <h1 class="heading">últimos productos</h1>

  
   <div class="box-container">
      <!-- Busco en la base de datos los últimos 9 productos añadidos ordenados descendiendo -->
   <?php
     $select_products = $conn->prepare("SELECT * FROM `productos` ORDER BY `id` DESC  LIMIT 9"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <!-- incluyo el componente box-product -->
   <?php include './components/box_product.php'; ?>
   <?php
      }
   }else{
      echo '<p class="empty">No hay productos añadidos aún.</p>';
   }
   ?>

   </div>

</section>


<!-- incluyo el componente footer -->
<?php include './components/footer.php'; ?>

<!-- Script que añade el slider -->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<!-- Configuración de los sliders de la página home -->
<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});



</script>



</body>
</html>