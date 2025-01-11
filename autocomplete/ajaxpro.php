<?php
    $hostName = "localhost";
    $username = "jhuerta";
    $password = "dFt&523$$.123";
    $dbname = "aplanado";

    $mysqli = new mysqli($hostName, $username, $password, $dbname); 
    $sql = "SELECT * FROM insumos WHERE nombre LIKE '%".$_GET['name']."%'";
    $result = $mysqli->query($sql);
    $response = [];
    if($result ->num_rows > 0){      

       while($row = mysqli_fetch_assoc($result)){
          $response[] = array("id"=>$row['id'], "name"=>$row['nombre']);
       }

       echo json_encode($response);
    }

?>