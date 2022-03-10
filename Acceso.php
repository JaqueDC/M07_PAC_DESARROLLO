<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso</title>
   

</head>


<body>
    <?php
    //Quitamos todos los errores y warnings (advertecias).
    /* error_reporting(0); */

    //Icluimos el código de otro archivo
    include 'BaseDatos.php';

    //Iniciamos la sesión
    $sesion = $_SESSION['usuario'];

    //Condición que mostrara unos enlaces u otros, dependiendo del tipo de usuario que es.
    if($sesion == "Jack Blue"){
      echo "<li><a href = 'Articulos.php'>Artículos</a></li>";
      echo "<li><a href = 'Usuarios.php'>Usuarios</a></li>";
      echo "<li><a href = 'Index.php'>Volver</a></li>";
     } else{
      echo "<li><a href = 'Articulos.php'>Artículos</a></li>";
      echo "<li><a href = 'Index.php'>Volver</a></li>";
    }
    ?>
</body>
</html>