<?php
error_reporting(0);

//Comenzar la sesión
if(!isset($_SESSION)){
    session_start();
}

function conexion(){
    return $conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');
}



//----------------------------------------------------------------INDEX--------------------------------------------------------------------------
//Función con los parámetros usuarios e email, donde comprobaremos si el usuario está registrado en la BD.
function getUser($usuario, $email){
    //Establecemos la conexión con la BD
	$conexion = conexion();
    //Consulta a la BD para ver si el usuario y correo están registrados y coinciden
	$usuario = $_POST['usuario'];
    $email = $_POST['email'];

	$sql = "SELECT Email, FullName FROM user WHERE Email = '$email' and FullName = '$usuario'";
	//Obtiene un array asociativo  
	$result = mysqli_query($conexion, $sql);

    //Condición que comprobará si el usuario coincide con el email y es correcto
	if(mysqli_num_rows($result) > 0){

        //iniciamos y creamos la sesión 
		session_start();
		$_SESSION['usuario'] = $usuario;
		/*var_dump($_SESSION['usuario']);*/

        //mensaje para dar la bienvenida y mostrar el link que llevará al acceso.
		echo "<p>Bienvenido $usuario pulsa <a href='Acceso.php'>Aquí</a> para continuar</p>";
	}
}



//----------------------------------------------------------------ACCESO---------------------------------------------------------------------------
//Fución para diferenciar si un usuario es autorizado o registrado
function tipoUsuario(){
	//Conexión a la Base de datos
    $conexion = conexion();
    //Consulta para comprobar si un usuario es autorizado o registrado
	$queryUsuario = mysqli_query($conexion, "SELECT `Enabled` FROM `user`");
	//Obtiene un array asociativo  
	$resultUsuario = mysqli_fetch_assoc($queryUsuario );

    //Condición que comprueba si el resultado de la query es igual a 1 (autorizado) o 2 (registrado)
	if($resultUsuario ['Enabled'] == 1) {
		$_SESSION['tipoUsuario'] = 'autorizado';
	} if ($resultUsuario ['Enabled'] == 0) {
		$_SESSION['tipoUsuario'] = 'registrado';
	}

}



//--------------------------------------------------------------ARTICULOS------------------------------------------------------------------------------

    //Funció para comprobar el enabled de un usuario y ver si es autorizado o registrado.
    function comprobarEnabled(){
        $conexion = conexion();

        $sesion = $_SESSION['usuario'];

        $sql = "SELECT Enabled FROM user WHERE FullName = '$sesion'";
        $query = mysqli_query($conexion, $sql);

        return $query;
        mysqli_close($conexion);
    }

    //-------------------------------------------Funciones para poder paginar la lista de artículos----------------------------------------------
    function idArticulos_T(){
        $conexion = conexion();
        //variable para obtener la página en la que estamos y luego poder movernos hacia adelante y atrás
        $inicio = $_GET['pagina'];
        //Multiplicamos por 10 (el número total de registros)
        $comienza = $inicio * 10;
        //Consulta para seleccionar el campo de la tabla y ordenarlo de manera ascedente
        $sql = "SELECT product.ProductID, product.Name, product.Cost, product.Price, category.Name 
                FROM product, category 
                WHERE category.CategoryID = product.CategoryID 
                ORDER BY product.ProductID 
                ASC LIMIT $comienza, 10";
        //Resultado de la query
        $query = mysqli_query($conexion, $sql);
        //Devolvemos la query
        return $query;
        //Cerramos la conexión
        mysqli_close($conexion);
    }

    function nombreArticulos_T(){
        $conexion = conexion();

        $inicio = $_GET['pagina'];
        $comienza = $inicio * 10;

        $sql = "SELECT product.ProductID, product.Name, product.Cost, product.Price, category.Name 
                FROM product, category 
                WHERE category.CategoryID = product.CategoryID 
                ORDER BY product.Name 
                ASC LIMIT $comienza, 10";
        $query = mysqli_query($conexion, $sql);
        
        return $query;
        mysqli_close($conexion);
    }

    function categoriaArticulos_T(){
        $conexion = conexion();

        $inicio = $_GET['pagina'];
        $comienza = $inicio * 10;

        $sql = "SELECT product.ProductID, product.Name, product.Cost, product.Price, category.Name 
        FROM product, category 
        WHERE category.CategoryID = product.CategoryID 
        ORDER BY category.Name 
        ASC LIMIT $comienza, 10";
        $query = mysqli_query($conexion, $sql);
        
        return $query;
        mysqli_close($conexion);
    }

    function costeArticulos_T(){
        $conexion = conexion();

        $inicio = $_GET['pagina'];
        $comienza = $inicio * 10;

        $sql = "SELECT product.ProductID, product.Name, product.Cost, product.Price, category.Name 
                FROM product, category 
                WHERE category.CategoryID = product.CategoryID 
                ORDER BY product.Cost 
                DESC LIMIT $comienza, 10";
        $query = mysqli_query($conexion, $sql);
        
        return $query;
        mysqli_close($conexion);
    }

    function precioArticulos_T(){
        $conexion = conexion();

        $inicio = $_GET['pagina'];
        $comienza = $inicio * 10;

        $sql = "SELECT product.ProductID, product.Name, product.Cost, product.Price, category.Name 
                FROM product, category 
                WHERE category.CategoryID = product.CategoryID 
                ORDER BY product.Price 
                DESC LIMIT $comienza, 10";
        $query = mysqli_query($conexion, $sql);
        
        return $query;
        mysqli_close($conexion);
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    //Función para seleccionar un artículo a partir de su ID.
    function articuloElegido(){
        $conexion = conexion();

        //$_GET recoge el dato de la url posterior a: ?
        $id = $_GET['id'];

        $sql = "SELECT ProductID, Name, Cost, Price, CategoryID FROM product WHERE ProductID = '$id'";
        $query = mysqli_query($conexion, $sql);
        
        return $query;
        mysqli_close($conexion);
    }

    //Función para agregar un nuevo artículo
    function crearArticulo(){
        
        $conexion = conexion();

        //Inroducimos dentro de variables los datos recogidos del formulario 
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $coste = $_POST['coste'];
        $precio = $_POST['precio'];
        $categoriaID = $_POST['categoria'];

        //Consulta SQL
        $sql = "INSERT INTO product (ProductID, Name, Cost, Price, CategoryID) 
                VALUES ('$id', '$nombre', '$coste', '$precio', '$categoriaID')";
        $crear = mysqli_query($conexion, $sql);
        
        return $crear;
        mysqli_close($conexion);
    }

    //Función para editar un arículo 
    function cambiarArticulo(){
        $conexion = conexion();

        //Inroducimos dentro de variables los datos recogidos del formulario 
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $coste = $_POST['coste'];
        $precio = $_POST['precio'];
        $categoriaID = $_POST['categoria'];

        //Consulta SQL
        $sql = "UPDATE product SET ProductID = '$id', Name = '$nombre', Cost = '$coste', Price = '$precio', CategoryID = '$categoriaID' 
                WHERE ProductID = '$id'";
        $query = mysqli_query($conexion, $sql);

        return $query;
        mysqli_close($conexion);
    }

    //Función para borrar un arículo 
    function eliminarArticulo(){
        $conexion = conexion();

        //Seleccionar los campos en los que el usuario introduce datos
        $id = $_POST['id'];

        //Consulta SQL
        $sql = "DELETE FROM product WHERE ProductID = '$id'";
        $query = mysqli_query($conexion, $sql);

        return $query;
        mysqli_close($conexion);
    }

    //Comprobar si el ID ya existe
    function comprobarIDArt(){
        $conexion = conexion();
        $id = $_POST['id'];

        $sql = "SELECT ProductID FROM product WHERE ProductID = '$id'";
        $comprobarArticulo = mysqli_query($conexion, $sql);
        
        return $comprobarArticulo;
        mysqli_close($conexion);
    }


//---------------------------------------------------------------USUARIOS-------------------------------------------------------------------------
    //-------------------------------------------Funciones para poder paginar la lista de usuarios----------------------------------------------
    function IdUsuariosL(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');

        $queryListaU = "SELECT UserID, FullName, Email, DATE_FORMAT(LastAccess, '%d/%m/%y') AS LastAccess, Enabled 
                        FROM user ORDER BY UserID";
        $query = mysqli_query($conexion, $queryListaU);
        
        return $query;

		mysqli_close($conexion);
    }

    function NomUsuarioL(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');

        $queryListaNU = "SELECT UserID, FullName, Email, DATE_FORMAT(LastAccess, '%d/%m/%y') AS LastAccess, Enabled 
                        FROM user ORDER BY FullName ASC";
        $query = mysqli_query($conexion, $queryListaNU);
        
        return $query;

		mysqli_close($conexion);
    }

    function EmailL(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');

        $queryListaE = "SELECT UserID, FullName, Email, DATE_FORMAT(LastAccess, '%d/%m/%y') AS LastAccess, Enabled 
                        FROM user ORDER BY Email";
        $query = mysqli_query($conexion, $queryListaE);
        
        return $query;

		mysqli_close($conexion);
    }

    function AccesoL(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');

        $queryListaLA = "SELECT UserID, FullName, Email, DATE_FORMAT(LastAccess, '%d/%m/%y') AS LastAccess, Enabled 
                        FROM user ORDER BY LastAccess DESC";
        $query = mysqli_query($conexion, $queryListaLA);
        
        return $query;

		mysqli_close($conexion);
    }


    function EnabledL(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');

        $queryListaE = "SELECT UserID, FullName, Email, DATE_FORMAT(LastAccess, '%d/%m/%y') AS LastAccess, Enabled 
                        FROM user ORDER BY Enabled DESC";
        $query = mysqli_query($conexion, $queryListaE);
        
        return $query;

		mysqli_close($conexion);
    }
    //-----------------------------------------------------------------------------------------------------------------------------------------------

    //Función para seleccionar los usuarios según su id
    function selectUsuario(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');

        //$_GET recoge el dato de la url posterior a: ?
        $id = $_GET['id'];

        $queryListaUE = "SELECT UserID, FullName, Email, LastAccess, Enabled FROM user WHERE UserID = '$id'";
        $query = mysqli_query($conexion, $queryListaUE);
        
        return $query;

		mysqli_close($conexion);
    }

    //Fución para crear un nuevo usuario
    function insertarUsuario(){
        
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');

        //Seleccionar los campos en los que el usuario introduce datos
        $id = $_POST['id'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];
        $nombre = $_POST['nombre'];
        $acceso = $_POST['fecha'];
        $permisos = $_POST['autorizado'];

        //Consulta SQL
        $sql = "INSERT INTO user (UserID, Email, Password, FullName, LastAccess, Enabled) 
                VALUES ('$id', '$email', '$contraseña', '$nombre', '$acceso', '$permisos')";
        $crear = mysqli_query($conexion, $sql);
        
        return $crear;

		mysqli_close($conexion);
    }

    //Función para editar el usuario
    function modificarUsuario(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');

        //Inroducimos dentro de variables los datos recogidos del formulario 
        $id = $_POST['id'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];
        $nombre = $_POST['nombre'];
        $acceso = $_POST['fecha'];
        $permisos = $_POST['autorizado'];

        //Consulta SQL
        $sql = "UPDATE user SET UserID = '$id', Email = '$email', Password = '$contraseña', FullName = '$nombre', LastAccess = '$acceso', Enabled = '$permisos' 
                WHERE UserID = '$id'";
        $query = mysqli_query($conexion, $sql);

        return $query;

		mysqli_close($conexion);
    }

    function eliminarUsuario(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');

        //Inroducimos dentro de variables los datos recogidos del formulario 
        $id = $_POST['id'];

        //Consulta SQL
        $sql = "DELETE FROM user WHERE UserID = $id";
        $query = mysqli_query($conexion, $sql);

        return $query;

		mysqli_close($conexion);
    }

    //Comprobar que el usuario y el email no estén repetidos
    function comprobarUsuario(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');
        $id = $_POST['id'];

        $sql = "SELECT UserID FROM user WHERE UserID = '$id'";
        $comprobarUsuario = mysqli_query($conexion, $sql);
        
        return $comprobarUsuario;

		mysqli_close($conexion);
    }

    function comprobarEmail(){
		$conexion = mysqli_connect('localhost:3308', 'root', '', 'pac3_daw');
        $email = $_POST['email'];

        $sql = "SELECT Email FROM user WHERE Email = '$email'";
        $comprobarEmail = mysqli_query($conexion, $sql);

        return $comprobarEmail;

		mysqli_close($conexion);
    }

?>