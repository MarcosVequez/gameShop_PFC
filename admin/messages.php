<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

// si no hay iniciada sesion de un admin reenvia a login

if(!isset($admin_id)){
   header('location:login.php');
};
//función que borra los mensajes
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `mensajes` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Mensajes</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="contacts">

<h1 class="heading">Mensajes</h1>

<div class="box-container">

   <?php
   //llamada a la base de datos para obtener los mensajes
      $select_messages = $conn->prepare("SELECT * FROM `mensajes`");
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <!-- Se muestran los mensajes -->
   <div class="box">
   <p> Id mensaje : <span><?= $fetch_message['id']; ?></span></p>
   <p> Id usuario : <span><?= $fetch_message['usuario_id']; ?></span></p>
   <p> Nombre : <span><?= $fetch_message['nombre']; ?></span></p>
   <p> Email : <span><?= $fetch_message['email']; ?></span></p>
   <p> Teléfono : <span><?= $fetch_message['telefono']; ?></span></p>
   <p> Mensaje : <span><?= $fetch_message['mensaje']; ?></span></p>
   <a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('¿Eliminar el mensaje?');" class="delete-btn">Eliminar</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay mensajes</p>';
      }
   ?>

</div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>