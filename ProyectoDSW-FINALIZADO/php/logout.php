<?php
    session_start();
    session_destroy();
    mysqli_close($conn);
    header("Location:../index.php");
    die();
?>