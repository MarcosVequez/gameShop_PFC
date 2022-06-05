<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Pedidos</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/web_header.php'; ?>

<section class="orders">

   <h1 class="heading">Pedidos</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">logueate para ver tus pedidos</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `pedidos` WHERE usuario_id = ?");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Fecha de pedido : <span><?= $fetch_orders['fecha_pedido']; ?></span></p>
      <p>Nombre: <span><?= $fetch_orders['nombre']; ?></span></p>
      <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Teléfono : <span><?= $fetch_orders['telefono']; ?></span></p>
      <p>Dirección : <span><?= $fetch_orders['direccion']; ?></span></p>
      <p>Método de pago : <span><?= $fetch_orders['metodo']; ?></span></p>
      <p>Productos : <span><?= $fetch_orders['total_productos']; ?></span></p>
      <p>Precio total : <span><?= $fetch_orders['total_precio']; ?> €</span></p>
      <p>Estado del pedido : <span style="color:<?php if($fetch_orders['estado_pedido'] == 'Pendiente'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['estado_pedido']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">No tienes pedidos</p>';
      }
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>