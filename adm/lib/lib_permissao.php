<?php
if(!isset($seg)){
    exit;
}
function carregarBtn($endereco, $conn){
    $result_btn = "SELECT pg.id id_pg, pg.endereco 
        FROM adms_paginas pg
        LEFT JOIN adms_nivacs_pgs nivpg ON nivpg.adms_paginas_id=pg.id        
        WHERE pg.endereco='" . $endereco . "' 
        AND (pg.adms_sits_pg_id=1
        AND nivpg.adms_niveis_acesso_id='" .$_SESSION['adms_niveis_acesso_id'] . "'
        AND nivpg.permissao=1) 
        LIMIT 1";
    $resultado_btn = mysqli_query($conn, $result_btn);
    if(($resultado_btn) && ($resultado_btn->num_rows != 0 )) {
        return true;
    } else {
        return false;
    }
}
