<?php
    $host = "mysql-estadistica.alwaysdata.net";
    $usuario = "433125";
    $password = "linadatos";
    $basedatos = "estadistica_escolar";

    $conn = new mysqli($host, $usuario, $password, $basedatos);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    $conn->set_charset("utf8");
?>