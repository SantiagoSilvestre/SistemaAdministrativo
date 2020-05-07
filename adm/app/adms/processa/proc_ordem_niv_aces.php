<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_niv_atual = "SELECT id, ordem
     FROM adms_niveis_acesso
     WHERE id = '".$id."' LIMIT 1";
    $resultado_niv_atual = mysqli_query($conn, $result_niv_atual);
    if (($resultado_niv_atual) && ($resultado_niv_atual->num_rows != 0)) {
        $row_niv_atual = mysqli_fetch_assoc($resultado_niv_atual);

        if($row_niv_atual['ordem'] > $_SESSION['ordem'] +1 ){
            $ordem = $row_niv_atual['ordem'];
            $ordem_super = $ordem - 1;

            $result_niv_super = "SELECT id, ordem 
             FROM adms_niveis_acesso
             WHERE ordem = '".$ordem_super."' LIMIT 1 ";
            $resultado_niv_super = mysqli_query($conn, $result_niv_super);
            $row_niv_super = mysqli_fetch_assoc($resultado_niv_super);
            // update para maior

            $result_niv_mov_sub = "UPDATE adms_niveis_acesso 
             SET ordem = '".$ordem."', 
             modified = NOW() 
             WHERE id = '".$row_niv_super['id']."'";
            mysqli_query($conn, $result_niv_mov_sub);

            
            // update para menor
            $result_niv_mov_up = "UPDATE adms_niveis_acesso 
             SET ordem = '".$ordem_super."', 
             modified = NOW() 
             WHERE id = '".$row_niv_atual['id']."'";
            mysqli_query($conn, $result_niv_mov_up);
            
            // Redirecionar 

            if (mysqli_affected_rows($conn)) {
                $_SESSION['msg'] = "<div class='alert alert-success'> Ordem alterada com sucesso</div>";
                $url_destino = pg.'/listar/list_niv_aces';
                header("Location: $url_destino"); 
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>  A Ordem não pode ser alterada</div>";
                $url_destino = pg.'/listar/list_niv_aces';
                header("Location: $url_destino"); 
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Nível de acesso não pode ser alterado </div>";
            $url_destino = pg.'/listar/list_niv_aces';
            header("Location: $url_destino");  
        }

    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Nível de acesso não encontrado</div>";
        $url_destino = pg.'/listar/list_niv_aces';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}