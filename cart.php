<?php

include 'components/connect.php';

session_start();

//Si hay sesión iniciada guardo en $user_id el usuario que ha iniciado la sesión si no lo dejo vacio
// y redirijo a login.php
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};

// Si ejecuto $_POST['delete'] borro de la tabla de carrito de la base de datos el producto que corresponde con carrito_id
if(isset($_POST['delete'])){
   $cart_id = $_POST['carrito_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `carrito` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}
// Si ejecuto $_POST['delete_all'] borro de la tabla de carrito de la base de datos todos producto que corresponden al usuario logueado
if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `carrito` WHERE usuario_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

// Actualizao la cantidad del producto que hay en el carrito
if(isset($_POST['update_qty'])){
   $cart_id = $_POST['carrito_id'];
   $qty = $_POST['cantidad'];   
   $update_qty = $conn->prepare("UPDATE `carrito` SET cantidad = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   //se mustra este mensaje una vez actualizada la cantidad
   $message[] = 'Cantidad del producto actualizada.';
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Carrito</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

  <!-- Incluyo el componente header -->    
<?php include 'components/web_header.php'; ?>

<section class="products shopping-cart">

   <h3 class="heading">Carrito</h3>

   <div class="box-container">

   <?php
      $total = 0;
      //Consulta a la base de datos que devuelve los productos del carrito del usuario logueado
      $select_cart = $conn->prepare("SELECT * FROM `carrito` WHERE usuario_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
         while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
   ?>
   <!-- Muestro los productos con los botones para actualizar la cantidad y eliminar del carrito -->
   <form action="" method="post" class="box">
      <!-- Guardo el valor de id del carrito para cuando se ejecuta la operación $_POST['delete'] del carrito -->
      <input type="hidden" name="carrito_id" value="<?= $fetch_cart['id']; ?>">
      <!-- Botón que lleva a la vista del producto quick_view.php  -->
      <a href="quick_view.php?pid=<?= $fetch_cart['producto_id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_cart['imagen']; ?>" alt="imagen producto">
      <div class="name"><?= $fetch_cart['nombre']; ?></div>
      <div class="flex">
         <div class="price"><?= $fetch_cart['precio']; ?> €</div>
         <input type="number" name="cantidad" class="qty" min="1" max="99" value="<?= $fetch_cart['cantidad']; ?>">
         <button type="submit" class="fas fa-edit" name="update_qty"></button>
      </div>
      <!-- Subtotal de precio de cada producto del carro-->
      <div class="sub-total"> sub total : <span><?= $sub_total = ($fetch_cart['precio'] * $fetch_cart['cantidad']); ?> €</span> </div>
      <input type="submit" value="Quitar del carrito"  class="delete-btn" name="delete">
   </form>
   <?php
   // calculo el total de precio del carro
   $total += $sub_total;
      }
   }else{
      // Si la consulta no devuelve ninguna fila se muestra este mensaje
      echo '<p class="empty">El carrito está vacio</p>';
   }
   ?>
   </div>
   <!--Muestro el precio total del carro y los botones para vaciar el carro y realizar el pedido -->
   <div class="cart-total">
      <p>Total : <span><?= $total; ?> €</span></p>
      <a href="shop.php" class="option-btn">Continuar comprando</a>
      <!--  Botón que ejecuta el $_GET['delete_all'], si el total es 0 está desabilitado --> 
      <a href="cart.php?delete_all" class="delete-btn <?= ($total > 0)?'':'disabled'; ?>">Vaciar el carrito</a>
      <a href="checkout.php" class="btn <?= ($total > 0)?'':'disabled'; ?>">Realizar pedido</a>
   </div>

</section>
<!--Incluyo el componente footer -->
<?php include './components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>