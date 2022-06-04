<?php

include 'components/connect.php';

session_start();
//Si hay sesion iniciada guardo en $user_id el usuario que ha iniciado la sesión si no lo dejo vacio
if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};
//función que crea un pedido en la base de datos
if(isset($_POST['pedido'])){

   $name = $_POST['nombre'];   
   $telefono = $_POST['telefono'];   
   $email = $_POST['email'];   
   $metodo = $_POST['metodo'];   
   $direccion =  $_POST['calle'] .', '. $_POST['piso'] .', '. $_POST['ciudad'] .', '. $_POST['provincia'] .', '. $_POST['pais'] .' - CP: '. $_POST['codigo_postal'];
   $total_productos = $_POST['total_productos'];
   $total_precio = $_POST['total_precio'];
   //compruebo que en el carrito hay productos
   $check_cart = $conn->prepare("SELECT * FROM `carrito` WHERE usuario_id = ?");
   $check_cart->execute([$user_id]);
   //si hay productos
   if($check_cart->rowCount() > 0){
      // guardo en pedido en la base de datos
      $insert_order = $conn->prepare("INSERT INTO `pedidos`(usuario_id, nombre, telefono, email, metodo, direccion, total_productos, total_precio) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $telefono, $email, $metodo, $direccion, $total_productos, $total_precio]);
      //borro los productos del carrito
      $delete_cart = $conn->prepare("DELETE FROM `carrito` WHERE usuario_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'Pedido realizado correctamente';
   }else{
      $message[] = 'Tu carrito está vacio';
   }

}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/web_header.php'; ?>

<section class="checkout-orders">

   <form action="" method="POST">

   <h3>Tus productos</h3>

      <div class="display-orders">
      <?php
         $total_precio = 0;
         $cart_items[] = '';
         //miro que el carrito tenga productos
         $select_cart = $conn->prepare("SELECT * FROM `carrito` WHERE usuario_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               //guardo los items concatenando nombre * precio
               $cart_items[] = $fetch_cart['nombre'].' ('.$fetch_cart['precio'].' x '. $fetch_cart['cantidad'].') - ';
               // lista de los productos 
               $total_productos = implode($cart_items);
               //sumo el precio de todos los productos
               $total_precio += ($fetch_cart['precio'] * $fetch_cart['cantidad']);
      ?><!-- muestro cada producto con su precio y la cantidad-->
         <p> <?= $fetch_cart['nombre']; ?> <span>(<?= $fetch_cart['precio'].' € x '. $fetch_cart['cantidad'] ; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">Tu carrito está vacio</p>';
         }
      ?>
         <input type="hidden" name="total_productos" value="<?= $total_productos; ?>">
         <input type="hidden" name="total_precio" value="<?= $total_precio; ?>" value="">
         <div class="grand-total">Total : <span><?= $total_precio; ?> €</span></div>
      </div>

      <h3>Realiza el pedido</h3>
         <!--Formulario para hacer el pedido -->
      <div class="flex">
         <div class="inputBox">
            <span>Nombre :</span>
            <input type="text" name="nombre" required readonly placeholder="introduce tu nombre" class="box" maxlength="100" value="<?= $fetch_profile["nombre"]; ?>">
         </div>
         <div class="inputBox">
            <span>Número de teléfono :</span>
            <input type="number" name="telefono" required placeholder="ej: 555555555" class="box" min="0" max="999999999" >
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" name="email" required readonly placeholder="Introduce tu email" class="box" maxlength="50" value="<?= $fetch_profile["email"]; ?>">
         </div>
         <div class="inputBox">
            <span>Método de pago:</span>
            <select name="metodo" class="box" required>
               <option value="Contrareembolso">Contrareembolso</option>
               <option value="Tarjeta de crédito">Tarjeta de crédito</option>
               <option value="Paypal">Paypal</option>               
            </select>
         </div>
         <div class="inputBox">
            <span>Dirección línea 1:</span>
            <input type="text" name="calle" placeholder="Nombre de la calle" class="box" maxlength="100" required>
         </div>
         <div class="inputBox">
            <span>Dirección línea 2:</span>
            <input type="text" name="piso" placeholder="Piso, escalera ..." class="box" maxlength="100" required>
         </div>
         <div class="inputBox">
            <span>Ciudad:</span>
            <input type="text" name="ciudad" placeholder="ej: A Coruña" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Provincia:</span>
            <input type="text" name="provincia" placeholder="ej: A Coruña" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>País:</span>
            <input type="text" name="pais" placeholder="ej: España" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Código Postal:</span>
            <input type="number" min="0" name="codigo_postal" placeholder="ej: 123456" min="0" max="99999" class="box" required>
         </div>
      </div>

      <input type="submit" name="pedido" class="btn <?= ($total_precio > 0)?'':'disabled'; ?>" value="Realizar Pedido">

   </form>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>