<?PHP
include_once('../template/cabecera.php');
?>
<?php

$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : '';
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : '';
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : '';
$txtAccion = (isset($_POST['accion'])) ? $_POST['accion'] : '';


//variables para ingresar a la base de datos

include('../config/bd.php');


//inicio del switch para saber la privinencia de la accion del boton
switch ($txtAccion) {
    //el Agregar dato es el texto que se muentra en el value del input.
    case 'Agregar':

         if($conn){
        //solo funciona cunado ingresamos lod¿s datos de manera manual    
        // $sql= "INSERT INTO libros(nombre, imagen)VALUES('aprende php' , 'imagen.png' )";
        // $conn->exec($sql);
        
        $stmt=$conn->prepare( "INSERT INTO libros(nombre, imagen)VALUES(:nombre , :imagen )"); 
        $stmt->bindParam(':nombre', $txtNombre);
      
        //servicio para poder mover el archivo de imagen a la carpeta de img con un nombre seguro
        $time= new DateTime();

        //este metodo lo que hace es devolver un nuevo nombre para el archivo de imagen que se introduce para almacenarlo despues en otra carpeta de manera ordenada y sin redundancias
        $nombreArch= ($txtImagen!='')? $time->getTimestamp()."_".$_FILES['txtImagen']['name'] : "imagen.png";
        //echo $nombreArch;
        //se esta almacenando el nombre temporal de la imagen, o nombre por default
        $tmpImagen= $_FILES['txtImagen']['tmp_name'];
        
        //condicional que evalua si el nombre temporal esta vacio o no
        
        if($tmpImagen!=''){
            /*el move_upload_file esta moviendo desde una direccion actual por default del archivo hacia una dureccion nueva hubicada en la carpeta img*/
             move_uploaded_file($tmpImagen, "../../img/".$nombreArch);
        
        }

        $stmt->bindParam(':imagen', $nombreArch);
        $stmt->execute();
        //echo 'fue el boton agregar';
   
         }
         header("Location: productos.php");
        break;
    case 'Modificar':
        if($conn){
        //solo funciona cunado ingresamos lod¿s datos de manera manual    
        // $sql= "INSERT INTO libros(nombre, imagen)VALUES('aprende php' , 'imagen.png' )";
        // $conn->exec($sql);
        $stmt=$conn->prepare( " UPDATE libros SET nombre=:nombre, imagen=:imagen   WHERE id=:id "); 
        $stmt->bindParam(':id', $txtID);
        $stmt->bindParam(':nombre', $txtNombre);
        $stmt->bindParam(':imagen', $txtImagen);
        $stmt->execute();     
         
        //condicional para validaar que la informacion no este vacia
        if($txtNombre!= ''){

            //se realiza el metodo para asignar el nombre con fecha a los archivos en caso de modificacion,
            //ya que estos no contaban con eso

            $time= new DateTime();
            $nombreArch= ($txtImagen!='')? $time->getTimestamp()."_".$_FILES['txtImagen']['name'] : "imagen.png";
            $tmpImagen= $_FILES['txtImagen']['tmp_name'];
            move_uploaded_file($tmpImagen, "../../img/".$nombreArch);


            //borramos el archivo anterior 
            $stmt= $conn->prepare("SELECT imagen FROM libros WHERE id=:id");
            $stmt->bindParam(':id', $txtID);
            $stmt->execute();
    
            $libro= $stmt->fetch(PDO::FETCH_LAZY);
    
            if(isset($libro['imagen']) && $libro['imagen']!='imagen.png' ){
                 if(file_exists('../../img/'.$libro['imagen'])){
    
                    unlink('../../img/'.$libro['imagen']);
                 }
    
            }


            //actualizamos la tabla 
            $stmt=$conn->prepare( " UPDATE libros SET imagen=:imagen  WHERE id=:id "); 
            $stmt->bindParam(':id', $txtID);
            $stmt->bindParam(':imagen', $nombreArch);
            $stmt->execute();     
             

        }

         }
        break;
    case 'Cancelar':
         header("Location: productos.php");
        break;
    case  'Seleccionar':
        //selecciona todos los valores que esten relacionados con el id enviado
        $stmt= $conn->prepare("SELECT * FROM libros WHERE id=:id");
        $stmt->bindParam(':id', $txtID);
        $stmt->execute();

        /*accedemos al metodo fetch y le asignamos al valor que viene le 
        y le asignamos el estylo PDO::FETCH_LAZY,  lo cual le asigan a 
        al objeto que llega sus respectivas cabeceras dependiendo de sus 
        posicion en el array*/
        $libro= $stmt->fetch(PDO::FETCH_LAZY);
      /*asiganemos los valores llegados del resultado a las variables globales 
      que corresponden a cada uno de los campos  */
        $txtID= $libro['id'];
        $txtNombre= $libro['nombre'];
        $txtImagen= $libro['imagen'];
        
        // echo 'estas usando el botn seleccionar';
        break;
    case  'Borrar':
        
        $stmt= $conn->prepare("SELECT imagen FROM libros WHERE id=:id");
        $stmt->bindParam(':id', $txtID);
        $stmt->execute();

        $libro= $stmt->fetch(PDO::FETCH_LAZY);

        if(isset($libro['imagen']) && $libro['imagen']!='imagen.png' ){
             if(file_exists('../../img/'.$libro['imagen'])){

                unlink('../../img/'.$libro['imagen']);
             }

        }

        //boton para borrar la informacion de cada una de las filas(rows)
         $stmt1= $conn->prepare("DELETE FROM libros WHERE id=:id");
         $stmt1->bindParam(':id', $txtID);
         $stmt1->execute();
         header("Location: productos.php");
        //echo 'estas usando el botn borrar';
        break;
    //f|in del switch
}

?>


<div class="col-md-5">


    <div class="card">
        <div class="card-header">
            <b>Datos del libro nuevo</b>
        </div>
        <div class="card-body">
            <br>
            <form action="productos.php" method="POST" enctype="multipart/form-data"> <!-- -->

                <div class="form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly value="<?php echo $txtID; ?>" class="form-control" name="txtID" id="txtID" placeholder="Escribe tu ID">
                </div>
                <br>
                <div class="form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" value="<?php echo $txtNombre; ?>" class="form-control" name="txtNombre" id="txtNombre"
                        placeholder="carga el nombre de tu archivo">
                </div>
                <br>
                <div class="form-group">

                    <label for="txtImagen">Imagen: <?php echo $txtImagen; ?></label>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen"
                        placeholder="carga tu archivo">
                </div>
                <br><br>
                <!-- area de botones -->


                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" value="Agregar"  <?php echo ($txtAccion=='Seleccionar')?"disabled": "";?>  class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" value="Modificar" <?php echo ($txtAccion!='Seleccionar')?"disabled": "";?> class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" value="Cancelar" <?php echo ($txtAccion!='Seleccionar')?"disabled": "";?> class="btn btn-primary">Cancelar</button>
                </div>

            </form>
        </div>

    </div>

</div>


<div class="col-md-7">
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <!-- el scope especifica que lo que esta dentro de la columna es la cabecera de la tabla -->
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            <!-- inclusion del servicio de conexion a base de datos para obtener los datos -->
            <?php
            include_once('../servicios/getProducts.php');
            ?>


            <!-- esta seccion se encarga de listar mediante un bucle todos los valores de la matriz
                 que se estan almacenando dentro de la variable $stmt, tambien se le hace ejecutar
                 la funcion fetch all la cual trae todos los resultados y los formatea a un estilo especifico,
                en este caso este estilo es PDO::FETCH_ASSOC , el cual le dice al resultado que se odene
                 por medio de columnas indexadas y relacionadas a una cabecera de columna, esto permite que 
                todos los valores que se devuelvan esten organizados por sus respectivas columnas-->
            <?php
            foreach($stmt1->fetchAll(PDO::FETCH_ASSOC) as $k){
            ?>
                <tr >
                    <td> <?php echo $k['id']?></td>
                    <td><?php echo $k['nombre']?></td>
                    <td>
                       
                        <!-- //incrustamos la imaagen del libro a travez de una etiqueta img -->
                        <!-- sol lee los formatos jif y png -->
                       <img class="img-thumbnail rounded " src=<?php echo "../../img/".$k['imagen']?> alt="imagen de portada del libro" width="50px" >
                       
                       
                     </td>
                    <td>
                      <!-- creacion de los botones de seleccionar y borrar -->
                     
                     <!-- creacion del formulario con los dos botones -->
                 
                         <form  method="POST">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $k['id']?>">
                           <input name="accion" type="submit" value="Seleccionar" class="btn btn-success"> 
                           <input name="accion" type="submit" value="Borrar" class="btn btn-warning">
                         </form>

                    </td> 
                </tr>
               
           <?php }?>

            </tbody>
        </table>

    </div>

</div>



<?PHP
include_once('../template/pie.php');
?>