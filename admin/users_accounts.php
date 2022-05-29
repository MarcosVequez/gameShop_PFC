<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `usuario` WHERE id = ?");
   $delete_user->execute([$delete_id]);
  /* $delete_orders = $conn->prepare("DELETE FROM `pedidos` WHERE usuario_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `mensajes` WHERE usuario_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `carrito` WHERE usuario_id = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE usuario_id = ?");
   $delete_wishlist->execute([$delete_id]);*/
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cuentas de usuario</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">Cuentas de usuarios</h1>

   <div class="box-container">

   <?php
      $select_accounts = $conn->prepare("SELECT * FROM `usuario` WHERE tipo_usuario = ?");
      $select_accounts->execute(['usuario']);
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> Id de usuario : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Nombre : <span><?= $fetch_accounts['nombre']; ?></span> </p>
      <p> Email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('¿Borra la cuenta? La información relacionada con el usuario también se borrará')" class="delete-btn">Borrar Cuenta</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay cuentas de usuarios</p>';
      }
   ?>

   </div>

</section>


<script src="../js/admin_script.js"></script>
   
</body>
</html>