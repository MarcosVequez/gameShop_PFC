<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $nombre = $_POST['nombre'];   
   $email = $_POST['email'];   
   $password = sha1($_POST['password']);   
   $cpassword = sha1($_POST['cpassword']);
   

   $select_user = $conn->prepare("SELECT * FROM `usuario` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'Ya existe un usuario con ese email';
   }else{
      if($password != $cpassword){
         $message[] = 'No coinciden las contraseñas';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `usuario`(nombre, email, password) VALUES(?,?,?)");
         $insert_user->execute([$nombre, $email, $password]);
         $message[] = 'Registro satisfactorio, ya puedes loguearte.';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/web_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Regístrate ahora</h3>
      <input type="text" name="nombre" required placeholder="Introduce tu nombre " maxlength="100"  class="box">
      <input type="email" name="email" required placeholder="Introduce tu email" maxlength="50"  class="box" >
      <input type="password" name="password" required placeholder="Introduce tu contraseña" minlength="6" maxlength="20"  class="box">
      <input type="password" name="cpassword" required placeholder="Repite contraseña" minlength="6" maxlength="20"  class="box">
      <input type="submit" value="Regístrate" class="btn" name="submit">
      <p>¿Ya tienes una cuenta?</p>
      <a href="login.php" class="option-btn">Login</a>
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
