<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}elseif(isset($_SESSION['admin_id'])){
    $admin_id = $_SESSION['admin_id'];
    header('location:admin/dashboard.php'); 
}
else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];  
   $password = sha1($_POST['password']);   

   $select_user = $conn->prepare("SELECT * FROM `usuario` WHERE email = ? AND password= ?");
   $select_user->execute([$email, $password]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
    if($row['tipo_usuario'] == 'admin'){
        $_SESSION['admin_id'] = $row['id'];
        header('location:admin/dashboard.php');

     }elseif($row['tipo_usuario'] == 'usuario'){
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
     }

   }else{
      $message[] = 'Contraseña o nombre de usuario incorrectos';
   }

}
?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/web_header.php'; ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Login </h3>
      <input type="email" name="email" required placeholder="Introduce tu email" maxlength="50"  class="box" >
      <input type="password" name="password" required placeholder="Introduce tu contraseña" maxlength="20"  class="box">
      <input type="submit" value="Login" class="btn" name="submit">
      <p>¿No tienes una cuenta?</p>
      <a href="register.php" class="option-btn">Regístrate</a>
   </form>

</section>

<?php include './components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>