<?php
//código que muestra un mensaje encima del header cuando se relizan algunas acciones en la web
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>
<!-- Header de la pagina de admin-->
<header class="header">

   <section class="flex">

      <a href="../admin/dashboard.php" class="logo">Admin<span>Panel</span></a>

      <nav class="navbar">
         <a href="../admin/dashboard.php">Panel</a>
         <a href="../admin/products.php">Productos</a>
         <a href="../admin/placed_orders.php">Pedidos</a>
         <a href="../admin/admin_accounts.php">Admistradores</a>
         <a href="../admin/users_accounts.php">Usuarios</a>
         <a href="../admin/messages.php">Mensajes</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
         //muestra el admin al pulsar en el icono de usuario
            $select_profile = $conn->prepare("SELECT * FROM `usuario` WHERE id = ?");
            $select_profile->execute([$admin_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile['nombre']; ?></p>
         <a href="../admin/update_profile.php" class="btn">Actualizar perfil</a>         
         <a href="../admin/register_admin.php" class="option-btn">Registrar administrador</a>   
         <a href="../components/logout.php" class="delete-btn" >Logout</a> 
      </div>

   </section>

</header>