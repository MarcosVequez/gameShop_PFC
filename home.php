<?php

include './components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}elseif(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    header('location:admin/dashboard.php'); 
}
else{
   $user_id = '';
};

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
   
<?php include './components/web_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="imagenes/home-img-2.png" alt="">
         </div>
         <div class="content">
            <span>Juegos de videoconsola</span>
            <h3>últimas novedades</h3>
            <a href="shop.php" class="btn">compra ahora</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="imagenes/home-img-2.png" alt="">
         </div>
         <div class="content">
            <span>Videoconsolas</span>
            <h3>Disfruta la nueva generación</h3>
            <a href="shop.php" class="btn">compra ahora</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="imagenes/home-img-3.png" alt="">
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

<section class="category">

   <h1 class="heading">compra por categoría</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=xboxGames" class="swiper-slide slide">
      <img src="imagenes/icon_01.png" alt="">
      <h3> Juegos Xbox One/Series</h3>
   </a>

   <a href="category.php?category=psGames" class="swiper-slide slide">
      <img src="imagenes/icon_02.png" alt="">
      <h3> Juegos Sony Ps4/PS5</h3>
   </a>

   <a href="category.php?category=switchGames" class="swiper-slide slide">
      <img src="imagenes/icon_03.png" alt="">
      <h3>Juegos Nintendo Switch</h3>
   </a>

   <a href="category.php?category=xboxConsole" class="swiper-slide slide">
      <img src="imagenes/icon_04.png" alt="">
      <h3>Videoconsolas Xbox</h3>
   </a>

   <a href="category.php?category=sonyPSConsole" class="swiper-slide slide">
      <img src="imagenes/icon_05.png" alt="">
      <h3>Videoconsolas Playstation</h3>
   </a>

   <a href="category.php?category=switchConsole" class="swiper-slide slide">
      <img src="imagenes/icon_06.png" alt="">
      <h3>Videoconsolas Switch</h3>
   </a>

   <a href="category.php?category=complementos" class="swiper-slide slide">
      <img src="imagenes/icon_07.png" alt="">
      <h3>Complementos / periféricos</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="home-products products">

   <h1 class="heading">últimos productos</h1>

  >
   <div class="box-container">
   <?php
     $select_products = $conn->prepare("SELECT * FROM `productos` ORDER BY `id` DESC  LIMIT 9"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="productoId" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="nombre" value="<?= $fetch_product['nombre']; ?>">
      <input type="hidden" name="precio" value="<?= $fetch_product['precio']; ?>">
      <input type="hidden" name="imagen" value="<?= $fetch_product['imagen_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['imagen_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['nombre']; ?></div>
      <div class="flex">
         <div class="price"><span>€</span><?= $fetch_product['precio']; ?></div>
         <input type="number" name="cantidad" class="qty" min="1" max="99" value="1">
      </div>
      <input type="submit" value="añadir al carrito" class="btn" name="add_to_cart">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">No hay productos añadidos aún.</p>';
   }
   ?>

   </div>

</section>



<?php include './components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>


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