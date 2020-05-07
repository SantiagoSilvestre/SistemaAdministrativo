<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_men_atual = "SELECT id, ordem
     FROM adms_menu
     WHERE id = '".$id."' LIMIT 1";
    $resultado_men_atual = mysqli_query($conn, $result_men_atual);
    if (($resultado_men_atual) && ($resultado_men_atual->num_rows != 0)) {
        $row_men_atual = mysqli_fetch_assoc($resultado_men_atual);

        $ordem = $row_men_atual['ordem'];
        $ordem_super = $ordem - 1;

        $result_men_super = "SELECT id, ordem 
            FROM adms_menu
            WHERE ordem = '".$ordem_super."' LIMIT 1 ";
        $resultado_men_super = mysqli_query($conn, $result_men_super);
        $row_men_super = mysqli_fetch_assoc($resultado_men_super);
        // update para maior

        $result_men_mov_sub = "UPDATE adms_menu 
            SET ordem = '".$ordem."', 
            modified = NOW() 
            WHERE id = '".$row_men_super['id']."'";
        mysqli_query($conn, $result_men_mov_sub);

        
        // update para menor
        $result_men_mov_up = "UPDATE adms_menu 
            SET ordem = '".$ordem_super."', 
            modified = NOW() 
            WHERE id = '".$row_men_atual['id']."'";
        mysqli_query($conn, $result_men_mov_up);
        
        // Redirecionar 

        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'> Ordem do menu com sucesso</div>";
            $url_destino = pg.'/listar/list_menu
            ';
            header("Location: $url_destino"); 
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>  A Ordem não pode ser alterada</div>";
            $url_destino = pg.'/listar/list_menu
            ';
            header("Location: $url_destino"); 
        }

    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> menu não encontrado</div>";
        $url_destino = pg.'/listar/list_menu';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}