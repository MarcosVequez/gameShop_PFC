<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $name = $_POST['name'];   
   $price = $_POST['price'];   
   $details = $_POST['details'];
   $category = $_POST['category'];

   $update_product = $conn->prepare("UPDATE `productos` SET nombre = ?, precio = ?, detalles = ?, categoria = ? WHERE id = ?");
   $update_product->execute([$name, $price, $details,$category, $pid]);

   $message[] = 'Producto actualizado correctamente';

   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image_01']['name'];   
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   if(!empty($image_01)){
      if($image_size_01 > 2000000){
         $message[] = 'La imagen es muy grande';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `productns` SET imagen_01 = ? WHERE id = ?");
         $update_image_01->execute([$image_01, $pid]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_image_01);
         $message[] = 'Imagen 1 actualizada correctamente';
      }
   }

   $old_image_02 = $_POST['old_image_02'];
   $image_02 = $_FILES['image_02']['name'];   ;
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   if(!empty($image_02)){
      if($image_size_02 > 2000000){
         $message[] = 'La imagen es muy grande';
      }else{
         $update_image_02 = $conn->prepare("UPDATE `productos` SET imagen_02 = ? WHERE id = ?");
         $update_image_02->execute([$image_02, $pid]);
         move_uploaded_file($image_tmp_name_02, $image_folder_02);
         unlink('../uploaded_img/'.$old_image_02);
         $message[] = 'Imagen 2 actualizada correctamente';
      }
   }

   $old_image_03 = $_POST['old_image_03'];
   $image_03 = $_FILES['image_03']['name'];   
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   if(!empty($image_03)){
      if($image_size_03 > 2000000){
         $message[] = 'La imagen es muy grande!';
      }else{
         $update_image_03 = $conn->prepare("UPDATE `productos` SET imagen_03 = ? WHERE id = ?");
         $update_image_03->execute([$image_03, $pid]);
         move_uploaded_file($image_tmp_name_03, $image_folder_03);
         unlink('../uploaded_img/'.$old_image_03);
         $message[] = 'Imagen 3 actualizada correctamente';
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
   <title>Actualizar producto</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">

   <h1 class="heading">Actualizar producto</h1>

   <?php
      $update_id = $_GET['update'];
      $select_products = $conn->prepare("SELECT * FROM `productos` WHERE id = ?");
      $select_products->execute([$update_id]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>

   <section class="add-products">

   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_products['imagen_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_products['imagen_02']; ?>">
      <input type="hidden" name="old_image_03" value="<?= $fetch_products['imagen_03']; ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_products['imagen_01']; ?>" alt="">
         </div>
         <div class="sub-image">
            <img src="../uploaded_img/<?= $fetch_products['imagen_01']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_products['imagen_02']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_products['imagen_03']; ?>" alt="">
         </div>
      </div>
      <span>Actualiza nombre</span>
      <input type="text" name="name" required class="box" maxlength="200" placeholder="Introduce el nombre del producto" value="<?= $fetch_products['nombre']; ?>">
      <span>Actualiza precio</span>
      <input type="number" name="price" required class="box" min="0" max="99999" step="0.01" placeholder="Precio del producto" value="<?= $fetch_products['precio']; ?>">
      <span>Descripción</span>
      <textarea name="details" class="box" required cols="30" rows="10"> <?= $fetch_products['detalles']; ?> </textarea>
      <span>Imagen 01</span>
      <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>Imagen 02</span>
      <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>Imagen 03</span>
      <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <div class="inputBox">
            <span>Categoría</span>
            <div class= "box">
                <p>Categoría actual: <span><?= $fetch_products['categoria']; ?></span> </p><br>
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
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="Actualizar">
         <a href="products.php" class="option-btn">Volver atrás</a>
      </div>
   </form>
   </section>
   <?php
         }
      }else{
         echo '<p class="empty">No hay productos</p>';
      }
   ?>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
