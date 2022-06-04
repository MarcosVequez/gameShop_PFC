<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];
// si no hay iniciada sesion de un admin reenvía a login
if(!isset($admin_id)){
   header('location:login.php');
}
//función que actualiza al administrador
if(isset($_POST['submit'])){

   $name = $_POST['nombre'];   
   $email = $_POST['email'];
   
// actualizo el nombre el email no porque no se puede cambiar en el formulario
   $update_profile = $conn->prepare("UPDATE `usuario` SET nombre = ?, email = ? WHERE id = ?");
   $update_profile->execute([$name, $email, $admin_id]);

   $prev_password = $_POST['prev_password'];
   $old_password = sha1($_POST['old_password']);   
   $new_password = sha1($_POST['new_password']);   
   $cpassword = sha1($_POST['cpassword']);   
   // compruebo que el password antiguo sea correctos
   if($old_password != $prev_password){
      $message[] = 'El password antiguo es incorrecto';
      //compruebo que los nuevos passswords sean distintos al antiguo
   }elseif($new_password == $old_password){
      $message[] = 'El nuevo password es igual al antiguo';
      //compruebo que los nuevos passwords sean iguales
   }elseif($new_password != $cpassword){
      $message[] = 'El nuevo password no coincide';
   }else{
      // actualizo el password
      $update_admin_pass = $conn->prepare("UPDATE `usuario` SET password = ? WHERE id = ?");
      $update_admin_pass->execute([$cpassword, $admin_id]);
      $message[] = 'Usuario actualizado';   
          
   }
   
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Actualizar administrador</title>
   
 
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
   
<?php include '../components/admin_header.php'; ?>

<section class="form-container">
<!-- Formulario para actualizar al admin-->
   <form action="" method="post">
      <h3>Actualiza el usuario</h3>
      <input type="hidden" name="prev_password" value="<?= $fetch_profile["password"]; ?>">
      <input type="text" name="nombre" required  placeholder="Introduce tu nombre"  maxlength="100"  class="box" value="<?= $fetch_profile["nombre"]; ?>">
      <input type="email" name="email" required readonly  placeholder="Introduce tu email"  maxlength="50"  class="box" value="<?= $fetch_profile["email"]; ?>">
      <input type="password" name="old_password" required placeholder="Introduce el antiguo password" maxlength="20"  class="box">
      <input type="password" name="new_password" required placeholder="Introduce el nuevo password" minlength="6" maxlength="20"  class="box">
      <input type="password" name="cpassword" required placeholder="Repite el nuevo password" minlength="6" maxlength="20"  class="box">
      <input type="submit" value="Actualizar" class="btn" name="submit">
   </form>

</section>


<script src="../js/admin_script.js"></script>

</body>
</html>