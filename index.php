<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <!-- Incluir código de otro archivo -->
    <?php
    //Quitamos todos los errores y warnings (advertecias).
    error_reporting(0);

    //Icluimos el código de otro archivo
    include 'BaseDatos.php';
    ?>

</head>



<body>
    <!-- Formulario de acceso -->
    <form action="index.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        <br>
        <input type="submit" value="Acceder">
    <!-- Código de php -->
        <?php
        /*Llamamos a la función getUser --> se encuentra en BaseDatos.php
          Con $_POST obtenemos los datos ingresados en usuario e email.*/
        getUser($_POST['usuario'], $_POST['email']);

        session_start();
                    //var_dump($_SESSION['Usuario']);

        
        ?>
    </form>

</body>
</html>