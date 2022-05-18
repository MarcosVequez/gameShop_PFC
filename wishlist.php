<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
};

include 'components/wishlist_cart.php';

if(isset($_POST['delete'])){
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE id = ?");
   $delete_wishlist_item->execute([$wishlist_id]);
}

if(isset($_GET['delete_all'])){
   $delete_wishlist_item = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist_item->execute([$user_id]);
   header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="es-ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Lista de deseos</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/web_header.php'; ?>

<section class="products">

   <h3 class="heading">Tu lista de deseos</h3>

   <div class="box-container">

   <?php
      $total = 0;
      $select_wishlist = $conn->prepare("SELECT * FROM `wishlist` WHERE usuario_id = ?");
      $select_wishlist->execute([$user_id]);
      if($select_wishlist->rowCount() > 0){
         while($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)){
            $total += $fetch_wishlist['precio'];  
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="producto_id" value="<?= $fetch_wishlist['producto_id']; ?>">
      <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
      <input type="hidden" name="nombre" value="<?= $fetch_wishlist['nombre']; ?>">
      <input type="hidden" name="precio" value="<?= $fetch_wishlist['precio']; ?>">
      <input type="hidden" name="imagen" value="<?= $fetch_wishlist['imagen']; ?>">
      <a href="quick_view.php?pid=<?= $fetch_wishlist['producto_id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_wishlist['imagen']; ?>" alt="imagen">
      <div class="name"><?= $fetch_wishlist['nombre']; ?></div>
      <div class="flex">
         <div class="price"><?= $fetch_wishlist['precio']; ?> €</div>
         <input type="number" name="cantidad" class="qty" min="1" max="99" value="1">
      </div>
      <input type="submit" value="Añadir al carro" class="btn" name="add_to_cart">
      <input type="submit" value="Eliminar de la lista" class="delete-btn" name="delete">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Tú lista de deseo está vacia</p>';
   }
   ?>
   </div>

   <div class="wishlist-total">
      <p>Total : <span><?= $total; ?>€</span></p>
      <a href="shop.php" class="option-btn">Continuar comprando</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($total > 1)?'':'disabled'; ?>">Vaciar lista de deseos</a>
   </div>

</section>




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>