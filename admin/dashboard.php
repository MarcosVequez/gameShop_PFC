<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];
// si no hay iniciada sesion de un admin reenvía a home

if(!isset($admin_id)){
   header('location:home.php');
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Menú Admin</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">Panel de administrador</h1>

   <div class="box-container">

      <div class="box">
         <h3>Bienvenido</h3>
         <p><?= $fetch_profile['nombre']; ?></p>
         <a href="update_profile.php" class="btn">Actualizar perfil</a>
      </div>

      <div class="box">
         <?php
         //muestra el número de pedidos pendientes
            $total_pendings = 0;
            $select_pendings = $conn->prepare("SELECT * FROM `pedidos` WHERE estado_pedido = ?");
            $select_pendings->execute(['Pendiente']);
            if($select_pendings->rowCount() > 0){
               while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                  $total_pendings += $fetch_pendings['total_precio'];
               }
            }
         ?>
         <h3><?= $total_pendings; ?><span> €</span></h3>
         <p>Total Pendientes</p>
         <a href="placed_orders.php" class="btn">Ver pedidos</a>
      </div>

      <div class="box">
         <?php
         //muesstra los pedidos completados
            $total_completes = 0;
            $select_completes = $conn->prepare("SELECT * FROM `pedidos` WHERE estado_pedido = ?");
            $select_completes->execute(['Completado']);
            if($select_completes->rowCount() > 0){
               while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                  $total_completes += $fetch_completes['total_precio'];
               }
            }
         ?>
         <h3><?= $total_completes; ?><span> €</span></h3>
         <p>Pedidos Completados</p>
         <a href="placed_orders.php" class="btn">Ver pedidos</a>
      </div>

      <div class="box">
         <?php
         //muestra el total de pedidos
            $select_orders = $conn->prepare("SELECT * FROM `pedidos`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount()
         ?>
         <h3><?= $number_of_orders; ?></h3>
         <p>Pedidos realizados</p>
         <a href="placed_orders.php" class="btn">Ver pedidos</a>
      </div>

      <div class="box">
         <?php
         //muestra el total de productos
            $select_products = $conn->prepare("SELECT * FROM `productos`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount()
         ?>
         <h3><?= $number_of_products; ?></h3>
         <p>Productos añadidos</p>
         <a href="products.php" class="btn">Ver productos</a>
      </div>

      <div class="box">
         <?php
            //muestra el total de usuarios
            $select_users = $conn->prepare("SELECT * FROM `usuario` WHERE tipo_usuario = ?");
            $select_users->execute(['usuario']);
            $number_of_users = $select_users->rowCount()
         ?>
         <h3><?= $number_of_users; ?></h3>
         <p>Usuarios</p>
         <a href="users_accounts.php" class="btn">Ver usuarios</a>
      </div>

      <div class="box">
         <?php
         //muestra el total de administradores
            $select_admins = $conn->prepare("SELECT * FROM `usuario` WHERE tipo_usuario = ?");
            $select_admins->execute(['admin']);
            $number_of_admins = $select_admins->rowCount()
         ?>
         <h3><?= $number_of_admins; ?></h3>
         <p>Administradores</p>
         <a href="admin_accounts.php" class="btn">Ver Administradores</a>
      </div>

      <div class="box">
         <?php
         //muestra el total de mensajes
            $select_messages = $conn->prepare("SELECT * FROM `mensajes`");
            $select_messages->execute();
            $number_of_messages = $select_messages->rowCount()
         ?>
         <h3><?= $number_of_messages; ?></h3>
         <p>Mensajes</p>
         <a href="messages.php" class="btn">Ver mensajes</a>
      </div>

   </div>

</section>


<script src="../js/admin_script.js"></script>
   
</body>
</html>