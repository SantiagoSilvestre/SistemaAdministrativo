<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_niv_aces = "SELECT * FROM adms_nivacs_pgs WHERE adms_menu_id = '".$id."'";
    $resultado_niv_aces = mysqli_query($conn, $result_niv_aces);

    if(($resultado_niv_aces) && ($resultado_niv_aces->num_rows != 0 )) {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Não pode ser apagado, há niveis de acesso para o menu! </div>";
        $url_destino = pg . '/listar/list_menu';
        header("Location: $url_destino");
    } else {

        $result_men_ver = "SELECT id, ordem AS ordem_result FROM adms_menu WHERE ordem > 
                          (SELECT ordem FROM adms_menu WHERE id='$id') ORDER BY ordem ASC";
        $resultado_men_ver = mysqli_query($conn, $result_men_ver); 
        
        $result_men = "DELETE FROM adms_menu WHERE id ='".$id."' ";
        $resultado_men = mysqli_query($conn, $result_men);

        if(mysqli_affected_rows($conn)) {

            if (($resultado_men_ver) && ($resultado_men_ver->num_rows != 0)) {
                while($row_men_ver = mysqli_fetch_assoc($resultado_men_ver)) {
                    $row_men_ver['ordem_result'] -= 1;
                    $result_men_or = "UPDATE adms_menu SET 
                     ordem='".$row_men_ver['ordem_result']."',
                     modified= NOW() WHERE id = '".$row_men_ver['id']."'";
                     mysqli_query($conn, $result_men_or);
                }
            }

            $_SESSION['msg'] = "<div class='alert alert-success'> Menu apagado com sucesso! </div>";
            $url_destino = pg . '/listar/list_menu';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro o menu não foi apagado! </div>";
            $url_destino = pg . '/listar/list_menu';
            header("Location: $url_destino");
       }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
