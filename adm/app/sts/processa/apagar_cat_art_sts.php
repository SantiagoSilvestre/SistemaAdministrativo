<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $ver = "SELECT * FROM sts_artigos where sts_cats_artigo_id = '".$id."'";
    $verifica = mysqli_query($conn, $ver);
    if(($verifica) && ($verifica->num_rows != 0)) {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Existem artigos com essa categoria! </div>";
        $url_destino = pg . '/listar/sts_list_cat_artigo';
        header("Location: $url_destino");
    } else {
        $result_car_del = "DELETE FROM sts_cats_artigos WHERE id ='".$id."' ";
        $resultado_car_del = mysqli_query($conn, $result_car_del);
    
        if(mysqli_affected_rows($conn)) {
    
            //Apaagar as permissões de acesso a página na tabela adms_nivac
            $_SESSION['msg'] = "<div class='alert alert-success'>Categoria apagada com sucesso! </div>";
            $url_destino = pg . '/listar/sts_list_cat_artigo';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro a Categoria STS não foi apagado! </div>";
            $url_destino = pg . '/listar/sts_list_cat_artigo';
            header("Location: $url_destino");
        }   
    }    
        
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

