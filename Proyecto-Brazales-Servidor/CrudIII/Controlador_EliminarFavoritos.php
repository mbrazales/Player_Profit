<?php
session_start();
    //Conexión
    include "Config/conexion.php";

// Eliminar todos los favoritos al recibir la solicitud
if (isset($_POST['eliminar_favoritos'])) {

    // Caducar la cookie de favoritos para eliminar todos los favoritos
    setcookie('favoritos', '', time() - 3600, '/'); 

    // Redireccionar a la página de favoritos
    header('Location: Vista_Favoritos.php');

    exit();
} else {

    // Si se intenta acceder directamente a este archivo sin una solicitud válida, redirigir a la página de favoritos
    header('Location: Vista_Favoritos.php');
    exit();
}
?>
