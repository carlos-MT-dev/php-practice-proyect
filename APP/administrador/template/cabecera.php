<!-- inicio de sesion para validar que antes de entrar a la pagina los usuarios se hallan logueado -->
<?PHP
// creando una sesion   
session_start();

//validando que existan datos en la sesion
if(!isset($_SESSION['usuario'])){

    header("Location:../index.php");
}else{

    if($_SESSION['usuario']){
        
      $nombreUSu= $_SESSION["nombreUSuario"];

    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>

       <!--creacion de una variable de redireccion de url-->
       <?PHP
       $url="http://".$_SERVER['HTTP_HOST']."/sitioweb_php/APP/index.php";
       $url1="http://".$_SERVER['HTTP_HOST']."/sitioweb_php/APP";
       ?>

      <!-- esto es el navbar de la parte superior de la pagina -->
      <nav class="navbar navbar-expand navbar-light bg-light primary">
          <div class="nav navbar-nav">
              <a class="nav-item nav-link active" href="#" >Administrador del sitio web</a>
              <a class="nav-item nav-link active" href="<?PHP echo $url1?>/administrador/inicio.php">Inicio</a>
              <a class="nav-item nav-link active" href="<?PHP echo $url1?>/administrador/seccion/productos.php">Administrador de libros</a>
              <a class="nav-item nav-link active" href="<?PHP echo $url1?>/administrador/seccion/cerrar.php">Cerrar sesion</a>
              <a class="nav-item nav-link active" href="<?PHP echo $url; ?>">Ver sitio web</a>
          </div>
      </nav>
      <!-- esto es el contenedor con texto alternativo -->
 <div class="container">
        <br> <br>
  <div class="row">