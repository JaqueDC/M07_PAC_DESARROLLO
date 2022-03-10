<?php
//Quitamos todos los errores y warnings (advertecias).
error_reporting(0);

//Icluimos el código de otro archivo
include 'BaseDatos.php';

//Iniciamos la sesión
session_start();

//Variables a utilizar
$boton="";
$imprimir = "";
$volver = "display: none;";
$formulario = "display: block;";

//Variables para que los campos estén rellenados con los datos del usuario que elegimos 
$rellenar_frm1 = "";
$rellenar_frm2 = "";
$rellenar_frm3 = "";
$rellenar_frm4 = "";
$rellenar_frm5 = "";
$rellenar_frm6 = "";
$rellenar_frm7 = "";


//asociamos la función como peticion sql en una variable
$query = selectUsuario();

//Bucle while que imprima los registros de la tabla usuario
while($mostrar = mysqli_fetch_assoc($query)){
    $rellenar_frm1 = $mostrar['UserID'];
    $rellenar_frm2 = $mostrar['FullName'];
    $rellenar_frm3 = $mostrar['Email'];
    $rellenar_frm4 = $mostrar['LastAccess'];
    $rellenar_frm5 = $mostrar['Enabled'];
}

//Si el usuario es autorizado, la opción de si aparecerá seleccionada
    if($rellenar_frm5 == 1){
        $rellenar_frm6 = "checked";
    }else{
        $rellenar_frm7 = "checked";
    }

//Condición para colocar botón de crear, modificar o borrar. Dependiendo de dónde hicimos click
if(isset($_POST['crear'])){
    $boton = "<input type='submit' name='añadir' value='Crear' class='boton'>";
    $imprimir = "<p>Se va a crear un usuario nuevo</p>";
} elseif(isset($_POST['modificar'])){
    $boton = "<input type='submit' name='cambiar' value='Modificar' class='boton'>";
    $imprimir = "<p>Se va a modificar el usuario $rellenar_frm2</p>";
}elseif(isset($_POST['borrar'])){
    $boton = "<input type='submit' name='eliminar' value='Borrar' class='boton'>";
    $imprimir = "<p>Se va a eliminar el usuario $rellenar_frm2</p>";
}

//Condición para añadir o editar un usuario, dendiedo de dónde hagamos click
//Para crear un nuevo usuario...
if(isset($_POST['añadir'])){
    if(mysqli_num_rows(comprobarUsuario()) > 0 || mysqli_num_rows(comprobarEmail()) > 0){
        //Mensaje de error, al colocar mal el usuaio o el email.
        $imprimir = '<p style= "color: red;">Error al crear el usuario.</p>';
        $boton = "<input type='submit' name='añadir' value='Crear' class='boton'>";
    }else{
        //LLamada a la función insertarUsuario (en BaseDatos.php)
        insertarUsuario();
        //Mensaje de que se ha creado corrctamente. Escondemos el formulario y mostramoos el enlace de regreso
        $imprimir = "<p>Se ha creado el Usuario</p>";
        $volver = "display: block;";
        $formulario = "display: none;";
    }

//Para modificar el usuario...
}elseif(isset($_POST['cambiar'])){
    //LLamada a la función modificarUsuario (en BaseDatos.php)
    modificarUsuario();
    //Mensaje de que se ha modificado correctamete. Escondemos el formulario y mostramoos el enlace de regreso
    $imprimir = "<p>Se ha modificado el Usuario</p>";
    $volver = "display: block;";
    $formulario = "display: none;";

//Para eliminar el usuario...
}elseif(isset($_POST['eliminar'])){
    //LLamada a la función eliminarUsuario (en BaseDatos.php)
     eliminarUsuario();
    //Mensaje de que se ha eliminado correctamete. Escondemos el formulario y mostramoos el enlace de regreso
    $imprimir = "<p>Se ha eliminado el Usuario</p>";
    $volver = "display: block;";
    $formulario = "display: none;";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>formulario de usuarios</title>
    </head>
    <body>
        <div class="contenedor">
        <center>
        <?php echo $imprimir?>
        <a href="Usuarios.php" style="<?php echo $volver?>"><button class="boton">Volver</button></a>

        <!-- Formulario para colocar los datos del usuario -->
        <form action="formUsuarios.php" method="POST" style="<?php echo $formulario?>">
            <Label for="id">ID:</Label>
            <input type="number" name="id" value="<?php echo $rellenar_frm1?>" required>
            <br>
            <Label for="nombre">Nombre:</Label>
            <input type="text" name="nombre" value="<?php echo $rellenar_frm2?>" required>
            <br>
            <input type="password" name="contraseña" value="">
            <Label for="contraseña">Contraseña:</Label>
            <br>
            <Label for="email">Correo:</Label>
            <input type="email" name="email" value="<?php echo $rellenar_frm3?>" required>
            <br>
            <Label for="fecha">Último acceso:</Label>
            <input type="date" name="fecha" value="<?php echo $rellenar_frm4?>">
            <br>
            <Label for="autorizado">Autorizado:</Label>
            <input type="radio" name="autorizado" value="1" <?php echo $rellenar_frm6?>>Sí
            <input type="radio" name="autorizado" value="0" <?php echo $rellenar_frm7?>>No
            <br>
            <!-- Botón para volver a usuarios -->
            <table>
                <tr>
                    <td colspan="2"><a href="Usuarios.php"><input type="button" value="Volver" class="volver_btn"></a> <?php echo $boton?></td>
                </tr>
            </table>
        </form>
        </center>    
        </div>
    </body>
</html>