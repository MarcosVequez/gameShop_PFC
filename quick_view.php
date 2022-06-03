<?php

include 'components/connect.php';

session_start();

//Si hay sesion iniciada guardo en $user_id el usuario que ha iniciado la sesión si no lo dejo vacio
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

//incluyo el componente wishlist_cart

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Vista Producto</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<!-- Incluyo el componente web_header -->
   
<?php include 'components/web_header.php'; ?>

<section class="quick-view">

   <h1 class="heading">Vista del producto</h1>

   <?php
      //Consulto a la base de datos el producto con la id de producto = pid
     $producto_id = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `productos` WHERE id = ?"); 
     $select_products->execute([$producto_id]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <!-- Guardo los valores que paso con el post cuando añado al carrito 
   o a la lista de deseos, los métodos post están en whislist_cart.php que está incluido anteriormente--> 
   <form action="" method="post" class="box">
      <input type="hidden" name="producto_id" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="nombre" value="<?= $fetch_product['nombre']; ?>">
      <input type="hidden" name="precio" value="<?= $fetch_product['precio']; ?>">
      <input type="hidden" name="imagen" value="<?= $fetch_product['imagen_01']; ?>">
      <!-- Muestro el producto-->
      <div class="row">
         <div class="image-container">
            <div class="main-image">
               <img src="uploaded_img/<?= $fetch_product['imagen_01']; ?>" alt="">
            </div>
            <div class="sub-image">
               <img src="uploaded_img/<?= $fetch_product['imagen_01']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['imagen_02']; ?>" alt="">
               <img src="uploaded_img/<?= $fetch_product['imagen_03']; ?>" alt="">
            </div>
         </div>
         <div class="content">
            <div class="name"><?= $fetch_product['nombre']; ?></div>
            <div class="flex">
               <div class="price"><span></span><?= $fetch_product['precio']; ?><span> €</span></div>
               <input type="number" name="cantidad" class="qty" min="1" max="99" value="1">
            </div>
            <div class="details"><?= $fetch_product['detalles']; ?></div>
            <!-- botones para añadir a la lista de deseos o al carrito -->
            <div class="flex-btn">
               <input type="submit" value="Añadir al carrito" class="btn" name="add_to_cart">
               <input class="option-btn" type="submit" value="Añadir a lista de deseos" name="add_to_wishlist" >
            </div>
         </div>
      </div>
   </form>
   <?php
      }
      // si al relizar la consulta a la base de datos no se recibe ninguna fila se muestra este mensaje
   }else{
      echo '<p class="empty">No existe ese producto en la tienda</p>';
   }
   ?>

</section>



<!-- Incluyo el componente footer -->

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
