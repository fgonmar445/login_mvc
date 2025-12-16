<?php

// views/login.php
if (isset($_SESSION['usuario_logueado'])) {  // si el usuario estuviera ya logeado, lo derivamos al inicio interno
    header("Location: ./dashboard.php");    // nosotros haremos comprobación de token
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <!-- aquí podríamos hacer un include de una cabecera común, si la hubiera, que incluyera incluso todas las etiquetas HTML anteriores -->

    <h1>Iniciar Sesión</h1>
    <?php
    if (isset($_GET['error'])) {
        echo '<p style="color: red;">' . $_GET['error'] . "</p>";
        unset($_GET['error']);
    }
    ?>
    <form action="index.php?action=authenticate" method="POST">
        <input type="idusuario" name="idusuario" placeholder="Identificador Usuario" required><br><br>
        <input type="password" name="password" placeholder="Contraseña" required><br><br>
        <button type="submit" name="login">Ingresar</button>
    </form>

    <!-- aquí podríamos hacer un include de un pie común, si lo hubiera, que incluyera incluso todas las etiquetas HTML posteriores -->

</body>
<script src="/login_mvc/public/verificaciones.js"></script>


</html>