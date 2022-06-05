<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_state'])){
   $order_id = $_POST['order_id'];
   $order_state = $_POST['order_state'];
   $update_state = $conn->prepare("UPDATE `pedidos` SET estado_pedido = ? WHERE id = ?");
   $update_state->execute([$order_state, $order_id]);
   $message[] = 'Actualizado el estado del pedido';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `pedidos` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pedidos</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">Pedidos</h1>

<div class="box-container">

   <?php
      $select_orders = $conn->prepare("SELECT * FROM `pedidos`");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Fecha del pedido: <span><?= $fetch_orders['fecha_pedido']; ?></span> </p>
      <p> Nombre: <span><?= $fetch_orders['nombre']; ?></span> </p>
      <p> Telefono: <span><?= $fetch_orders['telefono']; ?></span> </p>
      <p> Dirección: <span><?= $fetch_orders['direccion']; ?></span> </p>
      <p> Productos: <span><?= $fetch_orders['total_productos']; ?></span> </p>
      <p> Precio total: <span><?= $fetch_orders['total_precio']; ?> €</span> </p>
      <p> Método de pago: <span><?= $fetch_orders['metodo']; ?></span> </p>
      <p> Estado del pedido: <span><?= $fetch_orders['estado_pedido']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
         <select name="order_state" class="select">
            <option value="Pendiente">Pendiente</option>
            <option value="Completado">Completado</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="Actualizar" class="option-btn" name="update_state">
         <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('¿Eliminar este pedido?');">Eliminar</a>
        </div>
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay pedidos</p>';
      }
   ?>

</div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>