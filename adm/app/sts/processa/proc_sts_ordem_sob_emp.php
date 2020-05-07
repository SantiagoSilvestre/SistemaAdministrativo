<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    
    $result_sp_atual = "SELECT id, ordem
     FROM sts_sobs_emps
     WHERE id = '".$id."' LIMIT 1";
    $resultado_sp_atual = mysqli_query($conn, $result_sp_atual);
    
    if (($resultado_sp_atual) && ($resultado_sp_atual->num_rows != 0)) {
        $row_sp_atual = mysqli_fetch_assoc($resultado_sp_atual);

        $ordem = $row_sp_atual['ordem'];
        $ordem_super = $ordem - 1;

        $result_sp_super = "SELECT id, ordem 
            FROM sts_sobs_emps
            WHERE ordem = '".$ordem_super."' LIMIT 1 ";
        $resultado_sp_super = mysqli_query($conn, $result_sp_super);
        $row_sp_super = mysqli_fetch_assoc($resultado_sp_super);
        // update para maior

        $result_car_mov_sub = "UPDATE sts_sobs_emps 
            SET ordem = '".$ordem."', 
            modified = NOW() 
            WHERE id = '".$row_sp_super['id']."'";
        mysqli_query($conn, $result_car_mov_sub);

        
        // update para caror
        $result_car_mov_up = "UPDATE sts_sobs_emps 
            SET ordem = '".$ordem_super."', 
            modified = NOW() 
            WHERE id = '".$row_sp_atual['id']."'";
        mysqli_query($conn, $result_car_mov_up);
        
        // Redirecionar 

        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'> Ordem do Sobre empresa com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_sob_emp
            ';
            header("Location: $url_destino"); 
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>  A Ordem não pode ser alterada</div>";
            $url_destino = pg.'/listar/sts_list_sob_emp
            ';
            header("Location: $url_destino"); 
        }

    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Sobre empresa não encontrado</div>";
        $url_destino = pg.'/listar/sts_list_sob_emp';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}