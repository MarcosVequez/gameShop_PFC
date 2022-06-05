<?php

if(isset($_POST['add_to_wishlist'])){

   if($user_id == ''){
      header('location:login.php');
   }else{

      $productoId = $_POST['producto_id'];      
      $nombre = $_POST['nombre'];     
      $precio = $_POST['precio'];      
      $imagen = $_POST['imagen'];
     

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE producto_id = ? AND usuario_id = ?");
      $check_wishlist_numbers->execute([$productoId, $user_id]);

      $check_cart_numbers  = $conn->prepare("SELECT * FROM `carrito` WHERE producto_id = ? AND usuario_id = ?");
      $check_cart_numbers ->execute([$productoId, $user_id]);
    

      if($check_wishlist_numbers->rowCount() > 0){
         $message[] = 'Ya está en la lista de deseados.';
      }elseif($check_cart_numbers->rowCount() > 0){
         $message[] = 'Ya está añadido al carrito';
      }else{
         $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(usuario_id, producto_id, nombre, precio, imagen) VALUES(?,?,?,?,?)");
         $insert_wishlist->execute([$user_id, $productoId, $nombre, $precio, $imagen]);
         $message[] = 'Añadido a la lista de deseados.';
      }

   }

}

if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:login.php');
   }else{

      $productoId = $_POST['producto_id'];     
      $nombre = $_POST['nombre'];      
      $precio = $_POST['precio'];      
      $imagen = $_POST['imagen'];      
      $cantidad = $_POST['cantidad'];     

      $check_cart_numbers = $conn->prepare("SELECT * FROM `carrito` WHERE producto_id = ? AND usuario_id = ?");
      $check_cart_numbers->execute([$productoId, $user_id]);

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE producto_id = ? AND usuario_id = ?");
      $check_wishlist_numbers->execute([$productoId, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'Ya está añadido al carrito';

      }else{

         if($check_wishlist_numbers->rowCount() > 0){
            $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE nombre = ? AND usuario_id = ?");
            $delete_wishlist->execute([$nombre, $user_id]);
         }

         $insert_cart = $conn->prepare("INSERT INTO `carrito`(usuario_id, producto_id, nombre, precio, cantidad, imagen) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $productoId, $nombre, $precio, $cantidad, $imagen]);
         $message[] = 'Añadido al carrito';
         
      }

   }

}

?>