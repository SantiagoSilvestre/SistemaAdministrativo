<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $result_car_del = "DELETE FROM sts_contatos WHERE id ='".$id."' ";
    $resultado_car_del = mysqli_query($conn, $result_car_del);

    if(mysqli_affected_rows($conn)) {

        //Apaagar as permissões de acesso a página na tabela adms_nivac
        $_SESSION['msg'] = "<div class='alert alert-success'>Mensagme de contato apagada com sucesso! </div>";
        $url_destino = pg . '/listar/sts_list_contato';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Erro a Mensagme de contato STS não foi apagado! </div>";
        $url_destino = pg . '/listar/sts_list_contato';
        header("Location: $url_destino");
    }   

        
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

