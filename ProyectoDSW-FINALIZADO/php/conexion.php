<?php
    //Conexion a la Base de Datos (servidor,usuario,password)
    $conn = mysqli_connect("localhost", "root", "", "dsw");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>