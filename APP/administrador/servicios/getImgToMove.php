
<?php
include_once('../config/bd.php');

$time= new DateTime();

//este metodo lo que hace es devolver un nuevo nombre para el archivo de imagen que se introduce para almacenarlo despues en otra carpeta de manera ordenada y sin redundancias
$nombreArch= ($txtImagen!='')? $time->getTimestamp()."_".$_FILES['txtImagen']['name'] : "imagen.png";
echo $nombreArch;
//se esta almacenando el nombre temporal de la imagen, o nombre por default
$tmpImagen= $_FILES['txtImagen']['tmp_name'];

//condicional que evalua si el nombre temporal esta vacio o no

if($tmpImagen!=''){
    /*el move_upload_file esta moviendo desde una direccion actual por default del archivo hacia una dureccion nueva hubicada en la carpeta img*/
     move_uploaded_file($tmpImagen, "../../img/".$nombreArch);

}



?>