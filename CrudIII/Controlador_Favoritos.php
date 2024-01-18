<?php
session_start();

// Verificar si hay una sesión activa
if (!empty($_SESSION['email']) && !empty($_SESSION['pass'])) {

} else {

    // Si no hay sesión activa, redirigir a la página de inicio de sesión
    header('Location: login.php');
    exit();
}

//Condicion de control propia para saber si realmente está iniciando sesión
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {

    // El usuario ha iniciado sesión
    echo 'El usuario ha iniciado sesión.';
} else {

    // El usuario no ha iniciado sesión
    echo 'El usuario no ha iniciado sesión.';
}

if (!empty($_SESSION['nombre_usuario'])) {
    $nombreUsuario = $_SESSION['nombre_usuario'];

    // Crear una cookie con el nombre de usuario
    setcookie('nombre_usuario', $nombreUsuario, time() + (86400 * 30), '/'); // Cookie válida por 30 días

    echo "Se ha creado una cookie con el nombre de usuario: $nombreUsuario";
} else {
    echo "No hay un nombre de usuario en la sesión.";
}

// Verificar si se proporciona un ID válido de jugador en la solicitud GET
if (isset($_GET['id'])) {
    $jugador_id = $_GET['id'];

    // Verificar si la cookie de favoritos ya existe
    if (isset($_COOKIE['favoritos'])) {
        $favoritos = unserialize($_COOKIE['favoritos']); // Obtener la lista de favoritos existente desde la cookie
    } else {
        $favoritos = array(); // Si la cookie no existe, crear un array vacío
    }

    // Verificar si el jugador ya está en la lista de favoritos
    if (!in_array($jugador_id, $favoritos)) {

        $favoritos[] = $jugador_id; // Agregar el nuevo jugador a la lista de favoritos

        // Guardar la lista de favoritos en la cookie
        setcookie('favoritos', serialize($favoritos), time() + (86400 * 30), '/'); // La cookie expirará en 30 días
    }

    // Redireccionar de vuelta a la página de jugadores o a donde sea apropiado
    header('Location: Vista_Favoritos.php');
    exit();

} else {
    // Manejar el caso donde no se proporciona un ID de jugador válido
    echo "ID de jugador no válido";
}

// Cierre de sesión y eliminación de la cookie de favoritos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['logout'])) {
        
        // Eliminar la cookie de jugadores favoritos
        setcookie('favoritos', '', time() - 3600, '/'); // Caducar la cookie

        // Mensaje de depuración
        echo "Cookie 'favoritos' eliminada.";

        session_destroy();
        header('Location: Vista_Registro.php');
        exit();
    }
}
