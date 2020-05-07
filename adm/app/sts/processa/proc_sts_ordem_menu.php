<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_pg_atual = "SELECT id, ordem
     FROM sts_paginas
     WHERE id = '".$id."' LIMIT 1";
    $resultado_pg_atual = mysqli_query($conn, $result_pg_atual);
    if (($resultado_pg_atual) && ($resultado_pg_atual->num_rows != 0)) {
        $row_pg_atual = mysqli_fetch_assoc($resultado_pg_atual);

        $ordem = $row_pg_atual['ordem'];
        $ordem_super = $ordem - 1;

        $result_pg_super = "SELECT id, ordem 
            FROM sts_paginas
            WHERE ordem = '".$ordem_super."' LIMIT 1 ";
        $resultado_pg_super = mysqli_query($conn, $result_pg_super);
        $row_pg_super = mysqli_fetch_assoc($resultado_pg_super);
        // update para maior

        $result_pg_mov_sub = "UPDATE sts_paginas 
            SET ordem = '".$ordem."', 
            modified = NOW() 
            WHERE id = '".$row_pg_super['id']."'";
        mysqli_query($conn, $result_pg_mov_sub);

        
        // update para pgor
        $result_pg_mov_up = "UPDATE sts_paginas 
            SET ordem = '".$ordem_super."', 
            modified = NOW() 
            WHERE id = '".$row_pg_atual['id']."'";
        mysqli_query($conn, $result_pg_mov_up);
        
        // Redirecionar 

        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'> Ordem do menu com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_pagina
            ';
            header("Location: $url_destino"); 
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>  A Ordem não pode ser alterada</div>";
            $url_destino = pg.'/listar/sts_list_pagina
            ';
            header("Location: $url_destino"); 
        }

    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> menu não encontrado</div>";
        $url_destino = pg.'/listar/sts_list_pagina';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}