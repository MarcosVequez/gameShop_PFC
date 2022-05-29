<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['submit'])){

   $name = $_POST['nombre'];   
   $pass = sha1($_POST['password']);   
   $cpass = sha1($_POST['cpassword']);
   $email = $_POST['email'];
   $user_type = $_POST['user_type'];   

   $select_admin = $conn->prepare("SELECT * FROM `usuario` WHERE email = ?");
   $select_admin->execute([$email]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
    $message[] = 'Ya existe un administrador con ese email';
    }else{
      if($pass != $cpass){
         $message[] = 'Las contraseñas no coinciden';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `usuario`(nombre, email, password, tipo_usuario ) VALUES(?,?,?,?)");
         $insert_admin->execute([$name,$email, $cpass, $user_type]);
         $message[] = 'Administrador creado correctamente';
      }
   }
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registrar administrador</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Registro Administrador</h3>
      <input type="text" name="nombre" required placeholder="Introduce tu nombre " maxlength="100"  class="box">
      <input type="email" name="email" required placeholder="Introduce tu email" maxlength="50"  class="box" >
      <input type="password" name="password" required placeholder="Introduce tu contraseña" minlength="6" maxlength="20"  class="box">
      <input type="password" name="cpassword" required placeholder="Repite contraseña" minlength="6" maxlength="20"  class="box">
      <input type= "hidden" name="user_type" value="admin">
      <input type="submit" value="Registrar" class="btn" name="submit">
   </form>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>