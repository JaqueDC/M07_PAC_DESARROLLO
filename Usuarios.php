<?php
//Quitamos todos los errores y warnings (advertecias).
error_reporting(0);

//Icluimos el código de otro archivo
include 'BaseDatos.php';
    
//Creamos una variable para llamar a la función IdUsuariosL (se encuetra en BaseDatos.php)
$query = IdUsuariosL();

//Iniciamos la sesión
session_start();

//Condición para que, dependiendo de dónde hagamos click, se ordene nuestra tabla
if(isset($_POST['ID'])){
    $query = IdUsuariosL();
}elseif(isset($_POST['Nombre'])){
    $query = NomUsuarioL();
}elseif(isset($_POST['Email'])){
    $query = EmailL();
}elseif(isset($_POST['Acceso'])){
    $query = AccesoL();
}elseif(isset($_POST['Enabled'])){
    $query = EnabledL();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Usuarios</title>
    </head>
    <body>
        <div class="contenedor">
        <!-- Botón para crear un nuevo usuario -->
            <form action="formUsuarios.php" method="POST"><input type="submit" name = "crear" value="Crear Nuevo Usuario" class="modificar"></form>
        <!-- Tabla de usuarios -->
            <table class="tabla">
                <!-- Cabeceras de la tabla -->
                <tr>
                    <form action="Usuarios.php" method="POST">
                        <th><input type="submit" value="ID" name="ID" class="clasificar"></th>
                        <th><input type="submit" value="Nombre" name="Nombre" class="clasificar"></th>
                        <th><input type="submit" value="Email" name="Email" class="clasificar"></th>
                        <th><input type="submit" value="Último Acceso" name="Acceso" class="clasificar"></th>
                        <th><input type="submit" value="Enabled" name="Enabled" class="clasificar"></th>
                        <th colspan="2"><input type="submit" value="Modificar" class="clasificar"></th> 
                    </form>
                </tr>
                <?php
                    //Bucle while para que muestre los usuarios y sus datos siempre que se cumpla. 
                    while($mostrar = mysqli_fetch_array($query)){
                        $estilo = "";
                        $estilo2 = "";

                        //Si el usuario es Jack (El superAdmin), no podrá modificarse y aparecerá en color rojo
                        if($mostrar['FullName'] == "Jack Blue"){
                            $estilo = "color: red;";
                            $estilo2 = "display: none;";
                        }
                        ?>

                        <!-- Colocamos variables en cada columnas para mostrar la lista de la base de datos, y una
                             variable dentro de la etiqueta style para que el admin esté en color rojo -->
                        <tr>
                            <td name="id1" style="<?php echo $estilo?>"><?php echo $mostrar['UserID']?></td>
                            <td name="nombre1" style="<?php echo $estilo?>"><?php echo $mostrar['FullName']?></td>
                            <td name="email1" style="<?php echo $estilo?>"><?php echo $mostrar['Email']?></td>
                            <td name="ultimoacceso1" style="<?php echo $estilo?>"><?php echo $mostrar['LastAccess']?></td>
                            <td name="permiso1" style="<?php echo $estilo?>"><?php echo $mostrar['Enabled']?></td>
                            <td><form action="formUsuarios.php?id=<?php echo $mostrar['UserID']?>" method="POST" style="<?php echo $estilo2?>"><input type="submit" value="✎" name="modificar"></form></td>
                            <td><form action="formUsuarios.php?id=<?php echo $mostrar['UserID']?>" method="POST" style="<?php echo $estilo2?>"><input type="submit" value="✘" name="borrar"></form></td>
                        </tr>
                        <?php
                    }
                    
                ?>
            </table><br>
            <!-- Botón para volver a Acceso -->
            <a href="Acceso.php"><button class="botonVolver">Volver</button></a>
        </div>
    </body>
</html>