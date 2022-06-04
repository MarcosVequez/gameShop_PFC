<?php

include 'components/connect.php';

session_start();
//Si hay sesion iniciada guardo en $user_id el usuario que ha iniciado la sesión si no lo dejo vacio

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tienda</title>
   
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/web_header.php'; ?>

<section class="category">
<!-- incluyo el component de slider de categorías--> 
   <?php include './components/category_slider.php'; ?>

</section>

<section class="products">

   <h1 class="heading">últimos productos</h1>

   <div class="box-container">

   <?php
     //busco los últimos 6 productos añadidos a la base de datos
     $select_products = $conn->prepare("SELECT * FROM `productos` ORDER BY `id` DESC  LIMIT 6"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <?php include 'components/box_product.php'; ?>
   <?php
      }
   }else{
      echo '<p class="empty">No hay productos en la tienda</p>';
   }
   ?>

   </div>

</section>
<section class="products">

   <h1 class="heading">Juegos Xbox</h1>

   <div class="box-container">

   <?php
   //busco los últimos 6 juegos de xbox añadidos a la base de datos
     $category_name = 'Juegos Xbox';
     $select_products = $conn->prepare("SELECT * FROM `productos` WHERE categoria = ? ORDER BY `id`  DESC  LIMIT 6");     
     $select_products->execute([$category_name]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <?php include 'components/box_product.php'; ?>
   <?php
      }
   }else{
      echo '<p class="empty">No hay productos en la tienda</p>';
   }
   ?>

   </div>

</section>
<section class="products">

   <h1 class="heading">Juegos PlayStation</h1>

   <div class="box-container">

   <?php
   //busco los últimos 6 juegos de PlayStation añadidos a la base de datos
     $category_name = 'Juegos PlayStation';
     $select_products = $conn->prepare("SELECT * FROM `productos` WHERE categoria = ? ORDER BY `id`  DESC  LIMIT 6");     
     $select_products->execute([$category_name]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <?php include 'components/box_product.php'; ?>
   <?php
      }
   }else{
      echo '<p class="empty">No hay productos en la tienda</p>';
   }
   ?>

   </div>

</section>

</section>
<section class="products">

   <h1 class="heading">Juegos Switch</h1>

   <div class="box-container">

   <?php
   //busco los últimos 6 juegos de Switch añadidos a la base de datos
     $category_name = 'Juegos Switch';
     $select_products = $conn->prepare("SELECT * FROM `productos` WHERE categoria = ? ORDER BY `id`  DESC  LIMIT 6");     
     $select_products->execute([$category_name]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <?php include 'components/box_product.php'; ?>
   <?php
      }
   }else{
      echo '<p class="empty">No hay productos en la tienda</p>';
   }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>
//código de configuración del slider de categoría
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


