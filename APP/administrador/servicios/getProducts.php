<?php

// Conexión a la base de datos
include('../config/bd.php');

$query= "SELECT * FROM libros";

$stmt1= $conn->prepare($query); 
$stmt1->execute();

// setFetchMode: asigna el stylo de recepcion de la informacion que se recive del statement
/*PDO:: FETCH_ASSOC: es el parametro de setFechMode, que especifica como es que se recibira
 los valores provenientes de la base de datos, en este caso serecibira en un formato de matriz 
 indexada que relacionacada los datos por columnas con sus respectivas cabeceras*/


// $result= $stmt1->setFetchMode(PDO::FETCH_ASSOC);




/*
otra manera opcional de hacer la impresion de los datos mediante el foreach es:

$result=$stmt1->fechALl(PDO:FECH_ASSOC);

aqui result ya contiene todas los arrays provenientes de la base de datos

foreach($result as $res){

print_r($res);

de aqui dependiendo se hace la referencia de las columnas mediantes sus nombre $res['nombre_de_la_comlumna']
}
*/ 

?>