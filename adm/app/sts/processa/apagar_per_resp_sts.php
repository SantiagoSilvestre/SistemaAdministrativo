<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $result_car_del = "DELETE FROM sts_pergs_resps WHERE id ='".$id."' ";
    $resultado_car_del = mysqli_query($conn, $result_car_del);

    if(mysqli_affected_rows($conn)) {

        //Apaagar as permissões de acesso a página na tabela adms_nivac
        $_SESSION['msg'] = "<div class='alert alert-success'> FAQ STS apagada com sucesso! </div>";
        $url_destino = pg . '/listar/sts_list_perg_resp';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Erro o FAQ STS não foi apagado! </div>";
        $url_destino = pg . '/listar/sts_list_perg_resp';
        header("Location: $url_destino");
    }
    
        
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

