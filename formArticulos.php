<?php
//Quitamos todos los errores y warnings (advertecias).
error_reporting(0);

//Icluimos el código de otro archivo
include 'BaseDatos.php';

//Variables a  uilizar
    $boton = "";
    $imprimir = "";
    $volver = "display: none;"; //Para cuando no queramos mostrar un elemento
    $formulario = "display: block;"; //Para tratar a un elemento como bloque

//Variables para que los campos estén rellenados con los datos del usuario que elegimos 
    $rellenar_frm1 = "";
    $rellenar_frm2 = "";
    $rellenar_frm3 = "";
    $rellenar_frm4 = "";
    $rellenar_frm5 = "";
    $rellenar_frm6 = "";
    $rellenar_frm7 = "";
    $rellenar_frm8 = "";

    $query = articuloElegido(); //Llamamos a una función que se encuentra en BaseDatos.php

//Bucle while que recorre los registros de la tabla
    while($mostrar = mysqli_fetch_assoc($query)){
        $rellenar_frm1 = $mostrar['ProductID'];
        $rellenar_frm6 = $mostrar['Name'];
        $rellenar_frm7 = $mostrar['Cost'];
        $rellenar_frm8 = $mostrar['Price'];
        $rellenar_frm2 = $mostrar['CategoryID'];
    }

//Condición para comprobar cúal de las categorías está seleccionada (pantalon, camisa, jersey o chaqueta) 
    if($rellenar_frm2 == 1){
        $rellenar_frm2 = "selected";
    }elseif($rellenar_frm2 == 2){
        $rellenar_frm3 = "selected";
    }elseif($rellenar_frm2 == 3){
        $rellenar_frm4 = "selected";
    }elseif($rellenar_frm2 == 4){
        $rellenar_frm5 = "selected";
    }

//Identificar el botón pulsado en la página anterior

    if(isset($_POST['crear'])){
        $boton = "<input type='submit' name='añadir' value='Crear' class='boton'>";
        $imprimir = "<p>Se va a crear un artículo nuevo</p>";
    } elseif(isset($_POST['modificar'])){
        $boton = "<input type='submit' name='cambiar' value='Modificar' class='boton'>";
        $imprimir = "<p>Se va a modificar el artículo $rellenar_frm6</p>";
    }elseif(isset($_POST['borrar'])){
        $boton = "<input type='submit' name='eliminar' value='Eliminar' class='boton'>";
        $imprimir = "<p>Se va a eliminar el artículo $rellenar_frm6</p>";
    }

//Condición para que realice una acció u otra dependiendo del botón pulsado
    //Opción para añadir artículos...
    if(isset($_POST['añadir'])){
        if(mysqli_num_rows(comprobarIDArt()) > 0){
            $imprimir = '<p style= "color: red;">El ID introducido, ya existe.</p>';
            $boton = "<input type='submit' name='añadir' value='Crear' class='boton'>";
        }else{
            crearArticulo();

            //Mostrar mensaje, esconder el formulario y mostrar el enlace de regreso
            $imprimir = "<p>Se ha creado el producto</p>";
            $volver = "display: block;";
            $formulario = "display: none;";
        }
    //Opción para modificar artículos...
    }elseif(isset($_POST['cambiar'])){
        cambiarArticulo();

        //Mostrar mensaje, esconder el formulario y mostrar el enlace de regreso
        $imprimir = "<p>Se ha modificado el producto</p>";
        $volver = "display: block;";
        $formulario = "display: none;";

    //Opción para eliminar artículos...
    }elseif(isset($_POST['eliminar'])){
        eliminarArticulo();

        //Mostrar mensaje, esconder el formulario y mostrar el enlace de regreso
        $imprimir = "<p>Se ha borrado el producto</p>";
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
        <title>formulario de Artículos</title>
    </head>
    <body>
        <center>
        <?php echo $imprimir?>
        <a href="Articulos.php" style="<?php echo $volver?>"><button class="boton">Volver</button></a>
        <!-- Formulario  a rellenar con los datos de los artículos -->
        <form action="formArticulos.php?id=0" method="POST" style="<?php echo $formulario?>">
            <label for="id">ID:</label>
            <input type="number" name="id" value="<?php echo $rellenar_frm1?>" required>
            <br>
            <label for="categoria:">Categoría</label>
            <select name="categoria">
                <option <?php echo $rellenar_frm2?> value="1">Pantalón</option>
                <option <?php echo $rellenar_frm3?> value="2">Camisa</option>
                <option <?php echo $rellenar_frm4?> value="3">Jersey</option>
                <option <?php echo $rellenar_frm5?> value="4">Chaqueta</option>
            </select>
            <br>
            <label for="nombre:">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $rellenar_frm6?>" required>
            <br>
            <label for="coste">Coste:</label>
            <input type="number" name="coste" value="<?php echo $rellenar_frm7?>" required>
            <br>
            <label for="precio">Precio:</label>
            <input type="number" name="precio" value="<?php echo $rellenar_frm8?>" required>

            <table>
                <tr>
                    <td colspan="2"><a href="Articulos.php"><input type="button" value="Volver" class="boton"></a> <?php echo $boton?></td>
                </tr>
            </table> 
        </form>
    </center>
    </body>
</html>