<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];
// si no hay iniciada sesion de un admin reenvia a login
if(!isset($admin_id)){
   header('location:login.php');
}
//función que elimina a un usuario admin
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_admins = $conn->prepare("DELETE FROM `usuario` WHERE id = ?");
   $delete_admins->execute([$delete_id]);
   header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cuentas de administrador</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">Cuentas de administrador</h1>

   <div class="box-container">

   <div class="box">
      <p>Crear nuevo administrador</p>
      <a href="register_admin.php" class="option-btn">Registrar</a>
   </div>
   
   <?php
      //Petición a la base de datos para ver los usuarios admin
      $select_accounts = $conn->prepare("SELECT * FROM `usuario` WHERE tipo_usuario = ?");
      $select_accounts->execute(['admin']);
      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> Id administrador : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> Nombre : <span><?= $fetch_accounts['nombre']; ?></span> </p>
      <div class="flex-btn">
         
         <?php
         //en la ficha del admin logueado se muestra el botón actualizar
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="update_profile.php" class="option-btn">Actualizar</a>';
            }
            // en los otros admin se muestra el botón de eliminar
            else {?>
                <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('¿Borrar la cuenta?')" class="delete-btn">Eliminar</a>
            <?php }
         ?>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay cuentas de administrador</p>';
      }
   ?>

   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>

