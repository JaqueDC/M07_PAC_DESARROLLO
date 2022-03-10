<?php
//Quitamos todos los errores y warnings (advertecias).
error_reporting(0);

//Icluimos el código de otro archivo
include 'BaseDatos.php';

//Variables a utilizar
    $sesion = $_SESSION['usuario']; //
    $pagina = $_GET['pagina']; //
    $anterior = "display:none"; //
    $pagSiguiente = $pagina + 1;
    $pagAnterior = $pagina - 1;

//Condicional donde si la página es mayor que 0 entonces el botón aparece, sino desaparece
    if($pagina > 0){
        $anterior = "display:block";
    }else{
        $anterior = "display:none";
    }

//Colocamos en unas variables las funciones que están de BaseDatos.php
    $query = comprobarEnabled();
    $lista = idArticulos_T();

//Variable para hacer que desaparezca algo
    $estilo = "display: none";

//Bucle while que recorre la función comprobarEnabled. 
    while($mostrar = mysqli_fetch_assoc($query)){
        //Si el usuario está registrado muestra el botón para Crear un atículo
        if($mostrar['Enabled'] == 1){

            $enabled = "<form action='formArticulos.php?id=0' method='POST'><input type='submit' name = 'crear' value='Crear Nuevo Artículo' class='modificar'></form>";
        //Si el usuario es el SuperAdmin muestra el botón para Crear un atículo
        }elseif($sesion == "Jack Blue"){

            $enabled = "<form action='formArticulos.php?id=0' method='POST'><input type='submit' name = 'crear' value='Crear Nuevo Artículo' class='modificar'></form>";
            $estilo = "display: block";
        //Si el esuario es registrado no muestra el botón
        }else{
            $enabled = "";
        }
    }

    //Condición para que, dependiendo de dónde hagamos click, se ordene nuestra tabla
    if(isset($_POST['clickID'])){
        $lista = idArticulos_T();
    }elseif(isset($_POST['clickNombre'])){
        $lista = nombreArticulos_T();
    }elseif(isset($_POST['clickCategoria'])){
        $lista = categoriaArticulos_T();
    }elseif(isset($_POST['clickCoste'])){
        $lista = costeArticulos_T();
    }elseif(isset($_POST['clickPrecio'])){
        $lista = precioArticulos_T();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Artículos</title>
    </head>
    <body>
        <center>
        <?php echo $enabled?>
        <!-- Tabla de artículos -->
            <table class="tabla">
                <!-- Cabecera -->
                <tr>
                    <form action="Articulos.php?pagina=0" method="POST">
                        <th><input type="submit" value="ID" name="clickID" class="clasificar"></th>
                        <th><input type="submit" value="Categoría" name="clickCategoria" class="clasificar"></th>
                        <th><input type="submit" value="Nombre" name="clickNombre" class="clasificar"></th>
                        <th><input type="submit" value="Coste" name="clickCoste" class="clasificar"></th>
                        <th><input type="submit" value="Precio" name="clickPrecio" class="clasificar"></th>
                        <th colspan="2" style="<?php echo $estilo?>"><input type="submit" value="Modificar" class="clasificar"></th>
                    </form>
                </tr>
                <?php
                //Bucle para que imprima los registros de la Base de datos
                while($mostrar = mysqli_fetch_array($lista)){

                ?>
                    <tr>
                        <td name="id1"><?php echo $mostrar['ProductID']?></td>
                        <td name="categoria"><?php echo $mostrar[4]?></td> 
                        <td name="nombre"><?php echo $mostrar[1]?></td>
                        <td name="coste"><?php echo $mostrar['Cost']?></td>
                        <td name="precio"><?php echo $mostrar['Price']?></td>
                        <!-- Botones para editar o eliminar los artículos -->
                        <td style="<?php echo $estilo?>">
                            <form action="formArticulos.php?id=<?php echo $mostrar['ProductID']?>" method="POST">
                                <input type="submit" value="✎" name="modificar"> 
                                <input type="submit" value="✘" name="borrar">
                            </form>
                        </td>
                    </tr>
                <?php
                            
                }
                ?>
            </table><br>
            <!-- Botones para moverser por las páginas -->
            <table>
                <tr>
                    <td><form action="Articulos.php?pagina=<?php echo $pagAnterior?>" method="POST" style="<?php echo $anterior?>"><input type="submit" name="pagAnterior" value="<<<" class="botonAccion"></form></td>
                    <td><a href="Acceso.php"><button class="boton">Volver</button></a></td>
                    <td><form action="Articulos.php?pagina=<?php echo $pagSiguiente?>" method="POST"><input type="submit" name="pagSiguiente" value=">>>" class="botonAccion"></form></td>
                </tr>
            </table>
        </center>
    </body>
</html>