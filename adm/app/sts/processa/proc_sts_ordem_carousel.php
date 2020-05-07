<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    
    $result_car_atual = "SELECT id, ordem
     FROM sts_carousels
     WHERE id = '".$id."' LIMIT 1";
    $resultado_car_atual = mysqli_query($conn, $result_car_atual);
    
    if (($resultado_car_atual) && ($resultado_car_atual->num_rows != 0)) {
        $row_car_atual = mysqli_fetch_assoc($resultado_car_atual);

        $ordem = $row_car_atual['ordem'];
        $ordem_super = $ordem - 1;

        $result_car_super = "SELECT id, ordem 
            FROM sts_carousels
            WHERE ordem = '".$ordem_super."' LIMIT 1 ";
        $resultado_car_super = mysqli_query($conn, $result_car_super);
        $row_car_super = mysqli_fetch_assoc($resultado_car_super);
        // update para maior

        $result_car_mov_sub = "UPDATE sts_carousels 
            SET ordem = '".$ordem."', 
            modified = NOW() 
            WHERE id = '".$row_car_super['id']."'";
        mysqli_query($conn, $result_car_mov_sub);

        
        // update para caror
        $result_car_mov_up = "UPDATE sts_carousels 
            SET ordem = '".$ordem_super."', 
            modified = NOW() 
            WHERE id = '".$row_car_atual['id']."'";
        mysqli_query($conn, $result_car_mov_up);
        
        // Redirecionar 

        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'> Ordem do Carousel com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_carousels
            ';
            header("Location: $url_destino"); 
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>  A Ordem não pode ser alterada</div>";
            $url_destino = pg.'/listar/sts_list_carousels
            ';
            header("Location: $url_destino"); 
        }

    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Carousel não encontrado</div>";
        $url_destino = pg.'/listar/sts_list_carousels';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}