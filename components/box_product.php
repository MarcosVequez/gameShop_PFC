<!-- Código que muestra la tarjeta de un producto -->

<form action="" method="post" class="box">
      <input type="hidden" name="producto_id" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="nombre" value="<?= $fetch_product['nombre']; ?>">
      <input type="hidden" name="precio" value="<?= $fetch_product['precio']; ?>">
      <input type="hidden" name="imagen" value="<?= $fetch_product['imagen_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['imagen_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['nombre']; ?></div>
      <div class="flex">
         <div class="price"><span>€</span><?= $fetch_product['precio']; ?></div>
         <input type="number" name="cantidad" class="qty" min="1" max="99" value="1">
      </div>
      <input type="submit" value="añadir al carrito" class="btn" name="add_to_cart">
</form>