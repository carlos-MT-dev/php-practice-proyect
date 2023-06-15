

<?php

session_start();
//conexion a la base datos
$host = "localhost";
$bd = "sitio";
$usuario = "root";
$contraseña = "";

try{ 
    
    $conn= new PDO("mysql:host=localhost;dbname=sitio", $usuario, $contraseña);
    // accedemos a la funcion err_mode con el objetivo de que capte las excepciones que puedan surgir
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    

}catch(Exception $ex){
    
    echo "Warning: connection failed:".$ex->getMessage();
    
}
//traemoslos datos de los usuarios desde la bd
$consult= $conn->prepare("SELECT * FROM usuario WHERE categoria='Administrador' ");
$consult->execute();




?>
<?php

$usuario=(isset($_POST['usuario']))? $_POST['usuario']:"";
$contraseña=(isset($_POST['contraseña']))? $_POST['contraseña']:"";


foreach($consult->fetchAll(PDO::FETCH_ASSOC) as  $b){


if( $b['nombre']==$usuario && $b['contraseña']==$contraseña && $b['categoria']=='Administrador' ){
    $_SESSION['usuario']=$usuario;
    $_SESSION['nombreUSuario']="Carlos Murrugarra";
    header("Location:inicio.php");

}else if( $b['nombre']!==$usuario || $b['contraseña']!==$contraseña || $b['categoria']=='Administrador' ){
   $mensaje= "Error: El usuario y contraseña son incorrectos";

}

}

?>
<!-- me quede en que ahora debo hubicar esta logica en la cabecera hubicada en el template -->


<!doctype html>
<html lang="en">

<head>
    <title>LOGIN</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
</head>

<body>


    <div class="container">
        <br>
        <div class="row">
            <div class="col-3"></div>

            <div class="col-5">

                <!-- esto es un card para crear el login de acceso del adminitrador-->
                <div class="card">
                    <div class="card-header">
                        <b>LOGIN DE ACCESO: ADMINISTRADOR </b>
                    </div>

                    <div class="card-body">

                    <?php if(isset($mensaje)){ ?>
                          <div class="alert alert-danger" role="alert">
                             
                              <?php  echo $mensaje;?>
                          </div>
                    <?php } ?>
                        <form action="" method="POST">
                             <br>
                            <div class="form-group">
                                <label>User</label><br><br>
                                <input type="text" class="form-control" name="usuario"
                                    placeholder="Escribe tu usuario">
                            </div>
                              <br>
                            <div class="form-group">
                                <label for="exampleInputEmail">Password</label><br><br>
                                <input type="password" class="form-control" name="contraseña"
                                    placeholder="Escribe tu contraseña">
                            </div>
                            <br><br>

                            <input type="submit" class="btn btn-primary"></input>

                        </form>
                    </div>

                </div>

            </div>

        </div>
    </div>


</body>

</html>