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
   <title>Categoría</title>
   
   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

 
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
  <!-- Incluyo el header--> 
<?php include 'components/web_header.php'; ?>

<section class="category">
   <!-- Incluyo el category_slider--> 
   <?php include './components/category_slider.php'; ?>

</section>
<!-- Muestro los productos de la categoría-->
<section class="products">
    <?php  $category_name = $_GET['category']; ?>
    <!-- Cabecera con el nombre de la categoría--> 
   <h1 class="heading"> <?php echo $category_name ?> </h1>

   <div class="box-container">

   <?php
    // Consulta a la base de datos para obtener los productos de la categoría
     $select_products = $conn->prepare("SELECT * FROM `productos` WHERE categoria = ?"); 
     $select_products->execute([$category_name]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
     <!-- Incluyo el componente box_product-->
   <?php include './components/box_product.php'; ?>

   <?php
      }
   }else{
      //si no se obyien ninguan fila en la consulta se muestra este mensaje
      echo '<p class="empty">No hay productos de esa categoría.</p>';
   }
   ?>

   </div>

</section>

<!--incluyo el fotter-->
<?php include 'components/footer.php'; ?>
<!-- Script que carga el slider-->
<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<!--Configuración del slider -->
<script>


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