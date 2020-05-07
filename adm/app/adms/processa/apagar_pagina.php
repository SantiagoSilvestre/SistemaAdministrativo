<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_pg_del = "DELETE FROM adms_paginas WHERE id ='".$id."' ";
    $resultado_pg_del = mysqli_query($conn, $result_pg_del);

    if(mysqli_affected_rows($conn)) {

        //Apaagar as permissões de acesso a página na tabela adms_nivac

        $result_del_nivac = "DELETE FROM adms_nivacs_pgs WHERE adms_paginas_id = '".$id."'";
        mysqli_query($conn, $result_del_nivac);
        $_SESSION['msg'] = "<div class='alert alert-success'> Página apagada com sucesso! </div>";
        $url_destino = pg . '/listar/list_pagina';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Erro a página não foi apagada! </div>";
        $url_destino = pg . '/listar/list_pagina';
        header("Location: $url_destino");
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
