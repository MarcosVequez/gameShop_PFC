<!-- Conexion a la base de datos en localhost -->

<?php

$db_name = 'mysql:host=localhost;dbname=gameShop_db';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);

?> 

