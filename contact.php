<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   
};

if(isset($_POST['send'])){

   $name = $_POST['nombre'];
   $email = $_POST['email'];   
   $number = $_POST['telefono'];   
   $msg = $_POST['mensaje'];
   

   $select_message = $conn->prepare("SELECT * FROM `mensajes` WHERE nombre = ? AND email = ? AND telefono = ? AND mensaje = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'Ya has enviado este mensaje';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `mensajes`(usuario_id, nombre, email, telefono, mensaje) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'Mensaje enviado correctamente';

   }

}


?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contacto</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

 
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/web_header.php'; ?>
<section class="contact">
    <div class="box-container">
<?php
      if($user_id == ''){?>
            
                <p class="empty">Por favor Logueate para enviar un mensaje</p>
            
      <?php }else{ ?>


   <form action="" method="post">
      <h3>Ponte en contacto</h3>
      <input type="text" name="nombre" placeholder="Introduce tu nombre" required maxlength="50" class="box" value="<?= $fetch_profile["nombre"]; ?>">
      <input type="email" name="email" placeholder="Introduce tu email" required maxlength="50" class="box" value="<?= $fetch_profile["email"]; ?>">
      <input type="number" name="telefono" min="100000000" max="999999999"  placeholder="Introduce tu número de teléfono" required  class="box">
      <textarea name="mensaje" class="box" placeholder="Escribe tu mensaje" cols="30" rows="10" required></textarea>
      <input type="submit" value="Envía el mensaje" name="send" class="btn">
   </form>
  

<?php
      }
?>
    </div>
</section>       




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>