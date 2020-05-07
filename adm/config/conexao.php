<?php
 if(!isset($seg)){
    exit;
}

    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $dbname = "santiago";

    $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

    if(!$conn) {
        die("Falha na conexão: ".mysqli_connect_error());
    } else {
        //echo "conexão realizada com sucesso";
    }