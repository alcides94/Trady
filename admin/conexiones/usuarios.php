<?php 
                if ($_SERVER["REQUEST_METHOD"]=="POST") {
                    $id_anime=$_POST["id_anime"];
                    $titulo=$_POST["titulo"];
                    $nombre_estudio=$_POST["nombre_estudio"];
                    $anno_estreno=$_POST["anno_estreno"];
                    $num_temporadas=$_POST["num_temporadas"];

                /* $sql = "UPDATE animes SET
                            titulo = '$titulo',
                            nombre_estudio = '$nombre_estudio',
                            anno_estreno = $anno_estreno,
                            num_temporadas = $num_temporadas
                            WHERE id_anime = $id_anime";
                    
                    $_conexion -> query($sql);
                    */

                    #1. prepare

                    $sql = $_conexion -> prepare("UPDATE animes SET
                            titulo = ?,
                            nombre_estudio = ?,
                            anno_estreno = ?,
                            num_temporadas = ?,
                            WHERE id_anime = $id_anime"
                    );

                    #binding 
                    $sql -> bind_param("ssiii", 
                        $titulo,
                        $nombre_estudio,
                        $anno_estreno,
                        $num_temporadas
                        
                    );


                    #3. Ejecucion

                    $sql -> execute();
                    }
  
                    $sql= "SELECT * FROM estudios ORDER BY nombre_estudio";
                    $resultado = $_conexion -> query($sql);

                    $estudios=[];

                    var_dump($resultado);

                    while($fila=$resultado -> fetch_assoc()){
                        array_push($estudios, $fila["nombre_estudio"]);
                    }
                    
                    echo "<h1>". $_GET["id_anime"] ."</h1>";

                    $id_anime = $_GET["id_anime"];
                /* $sql="SELECT * FROM animes WHERE id_anime = '$id_anime'";
                    $resultado = $_conexion -> query($sql);
                    */
                    
                    #1. Preparacion (definimos la estructura de la sentencia)
                    $sql= $_conexion->prepare("SELECT * FROM animes WHERE id_anime = ?");
                    
                    #2. Enlazado (Vinculamos las interrogaciones con las variables y tipos)

                    $sql -> bind_param("i", $id_anime);

                    #3. Ejecucion

                    $sql ->execute();

                    #PASO ADICIONAL PARA LOS SELECT

                    $resultado =$sql -> get_result();

                    /**
                     * PREPARED STATEMENTS -> SENTANCIAS PREPARADAS
                     * 
                     * 1. Preparacion (prepare)
                     * 2. Enlazado
                     * 3. Ejecucion (execute)
                     */

                    #1. Preparacion (definimos la estructura de la sentencia)
                    $sql =$_conexion -> prepare("DELETE FROM animes WHERE id_anime= ?");

                    #2. Enlazado (Vinculamos las interrogaciones con las variables y tipos)

                    $sql -> bind_param("i", $id_anime);

                    #3. Ejecucion


                    $sql ->execute();

                    $anime = $resultado -> fetch_assoc();

            ?>
