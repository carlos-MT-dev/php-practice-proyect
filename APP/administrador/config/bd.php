

<?php

$host = "localhost";
$bd = "sitio";
$usuario = "root";
$contraseña = "";

try{ 

  $conn= new PDO("mysql:host=localhost;dbname=sitio", $usuario, $contraseña);
   // accedemos a la funcion err_mode con el objetivo de que capte las excepciones que puedan surgir
  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

//   if($conn){ 
    
//     echo "connection succesfully";

// }
//  else{echo "some wrong happeng in connection process";}

}catch(Exception $ex){
    
      echo "Warning: connection failed:".$ex->getMessage();

}
?>