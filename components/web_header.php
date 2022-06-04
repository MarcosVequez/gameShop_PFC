<!--función que muestra un mensaje encima del header-->
<?php
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

<header class="header">

   <section class="flex">

      <a href="home.php" class="logo">game<span>Shop</span></a>

      <nav class="navbar">
         <a href="home.php">Inicio</a>
         <a href="about.php">Sobre nosotros</a>
         <a href="orders.php">Pedidos</a>
         <a href="shop.php">Tienda</a>
         <a href="contact.php">Contacto</a>
      </nav>

      <div class="icons">
         <?php
         //llamada para contar los productos en la lista de deseos del usuario logueado
            $count_wishlist_items = $conn->prepare("SELECT * FROM `wishlist` WHERE usuario_id = ?");
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_counts = $count_wishlist_items->rowCount();
         //llamada para contar los productos en el carrito del usuario logueado
            $count_cart_items = $conn->prepare("SELECT * FROM `carrito` WHERE usuario_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_counts = $count_cart_items->rowCount();
         ?>
         <!-- Muestro los iconos con el número obtenido antes al lado -->
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-search"></i></a>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
      </div>
      <!-- Menú que se abre al pulsar sobre el icono del usuario-->
      <div class="profile">
         <?php          
            $select_profile = $conn->prepare("SELECT * FROM `usuario` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p><?= $fetch_profile["nombre"]; ?></p>
         <a href="update_user.php" class="btn">Actualizar perfil</a>
         <a href="components/logout.php" class="delete-btn" >Logout</a> 
         <?php
            }else{
         ?>
         <p>Por favor primero haz Login o Regístrate</p>
         <div class="flex-btn">
            <a href="register.php" class="option-btn">registro</a>
            <a href="login.php" class="option-btn">login</a>
         </div>
         <?php
            }
         ?>      
         
         
      </div>

   </section>

</header>