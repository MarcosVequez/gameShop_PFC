<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

// si no hay iniciada sesion de un admin reenvia a login

if(!isset($admin_id)){
   header('location:admin_login.php');
};
//función que añade un producto
if(isset($_POST['add_product'])){

   $name = $_POST['name'];   
   $price = $_POST['price']; 
   $details = $_POST['details'];
   $category = $_POST['category'];   

   $image_01 = $_FILES['image_01']['name'];  
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];   
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   $image_03 = $_FILES['image_03']['name'];   
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;
//compruebo que no ecxista ya un producto con ese nombre
   $select_products = $conn->prepare("SELECT * FROM `productos` WHERE nombre = ?");
   $select_products->execute([$name]);
// si existe se muestra este mensaje
   if($select_products->rowCount() > 0){
      $message[] = 'Ya hay un producto con ese nombre';
   }else{
      // si no se añade a la base de datos
      $insert_products = $conn->prepare("INSERT INTO `productos`(nombre, detalles, precio, categoria, imagen_01, imagen_02, imagen_03) VALUES(?,?,?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $category, $image_01, $image_02, $image_03]);

      if($insert_products){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message[] = 'Las imagenes son demasiado grandes';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'Nuevo producto añadido';
         }

      }

   }  

};

//función para borrar los productos

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `productos` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['imagen_01']);
   unlink('../uploaded_img/'.$fetch_delete_image['imagen_02']);
   unlink('../uploaded_img/'.$fetch_delete_image['imagen_03']);
   $delete_product = $conn->prepare("DELETE FROM `productos` WHERE id = ?");
   $delete_product->execute([$delete_id]);

   // esta parte no es necesaria porque al borrar el producto ya se borran las filas de las demás tablas relacionadas

   /*$delete_cart = $conn->prepare("DELETE FROM `carrito` WHERE producto_id = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE producto_id = ?");
   $delete_wishlist->execute([$delete_id]);*/
   header('location:products.php');
}


?>

<!DOCTYPE html>
<html lang="es_ES">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Productos</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">Añadir producto</h1>
   <!-- Formulario para añadir producto-->
   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Nombre del producto</span>
            <input type="text" name="name" maxlength="200" placeholder="Nombre del producto" class="box" required>
         </div>
         <div class="inputBox">
            <span>Precio</span>
            <input type="number" name="price" min="0"  max="99999" step="0.01" placeholder="Precio" class="box" required >
         </div>
        <div class="inputBox">
            <span>Imagen 1</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Imagen 2</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Imagen 3</span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>Descripción</span>
            <textarea name="details" placeholder="Descripción del producto" class="box" required maxlength="800" cols="30" rows="10"></textarea>
         </div>
         <div class="inputBox">
            <span>Categoría</span>
            <div class= "box">
                <select name="category" class="select" required>
                <option value="Juegos Xbox">Juegos Xbox</option>
                <option value="Juegos Playstation">Juegos Playstation</option>
                <option value="Juegos Switch">Juegos Switch</option>
                <option value="Videoconsolas Xbox">Videoconsolas Xbox</option>
                <option value="Videoconsolas Playstation">Videoconsolas Playstation</option>
                <option value="Videoconsolas Switch">Videoconsolas Switch</option>
                <option value="Complementos">Complementos</option>                
                </select>
            </div>
         </div>
      </div>
      
      <input type="submit" value="Añadir Producto" class="btn" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">Productos añadidos</h1>

   <div class="box-container">

   <?php
   //muestro los productos añadidos
      $select_products = $conn->prepare("SELECT * FROM `productos` ORDER BY `id` DESC ");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['imagen_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['nombre']; ?></div>
      <div class="price"><span><?= $fetch_products['precio']; ?></span>€</div>
      <div class="details"><span><?= $fetch_products['detalles']; ?></span></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Actualizar</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('¿Borrar este producto?');">Eliminar</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No hay productos añadidos</p>';
      }
   ?>
   
   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>

