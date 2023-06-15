<!-- va a incluir los productos: en este caso son los libros -->

<?php
include("templates/cabecera.php");
include("administrador/config/bd.php");


//hacemos la consulta de cuales son los libros disponibles en la bd

$stmt= $conn->prepare("SELECT *FROM libros"); 
$stmt->execute();
$result= $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- vamos a insertar un pequeño codigo de un card -->




<?php  foreach($result as $lib){?>
<div class="col-3">
    <div class="card">
        <img class="card-img-top" src="./img/<?php echo $lib["imagen"];?>" alt="Title">
        <div class="card-body">
            <h4 class="card-title"><?php echo $lib['nombre']?></h4>
            <a name="" id="" class="btn btn-primary" href="http://goalkicker.com" role="button">Ver mas</a>
        </div>
    </div>

</div>
<?php  }?>



<?php
include("templates/piePag.php");
?>