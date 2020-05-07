<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    //Checking if there are users in the level of acess befero after delete

    $result_user = "SELECT id FROM adms_usuarios
     WHERE adms_niveis_acesso_id = '" . $id . "' LIMIT 1 ";
    $resultado_user = mysqli_query($conn, $result_user);
    if (($resultado_user) && ($resultado_user->num_rows != 0)) {
        $_SESSION['msg'] = "<div class='alert alert-warning'> O nível de acesso não pode ser apagado, há usuários
        cadastrados para esse nível </div>";
        $url_destino = pg . '/listar/list_niv_aces';
        header("Location: $url_destino");
    } else { 
//search in database if exist order to up
        $result_niv_aces = "SELECT id, ordem AS ordem_result
FROM adms_niveis_acesso
WHERE ordem > (
    SELECT ordem
    FROM adms_niveis_acesso
    WHERE id ='$id'
) ORDER BY ordem ASC ";
        $resultado_niv_aces = mysqli_query($conn, $result_niv_aces);

//Delete
        $result_niv_aces_del = "DELETE FROM adms_niveis_acesso
WHERE id = '" . $id . "'
AND ordem > '" . $_SESSION['ordem'] . "' ";
        mysqli_query($conn, $result_niv_aces_del);
        if (mysqli_affected_rows($conn)) {
            // Update the sentece this order for not letless anything number this order empty

            if (($resultado_niv_aces) && ($resultado_niv_aces->num_rows != 0)) {
                while ($row_niv_aces = mysqli_fetch_assoc($resultado_niv_aces)) {
                    $row_niv_aces['ordem_result'] = $row_niv_aces['ordem_result'] - 1;
                    $result_niv_or = "UPDATE adms_niveis_acesso
            SET ordem = '" . $row_niv_aces['ordem_result'] . "',
            modified = NOw()
            WHERE id = '" . $row_niv_aces['id'] . "' ";
                    mysqli_query($conn, $result_niv_or);
                }
            }
            $_SESSION['msg'] = "<div class='alert alert-success'> O nível de acesso foi apagado </div>";
            $url_destino = pg . '/listar/list_niv_aces';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> O nível de acesso não foi apagado </div>";
            $url_destino = pg . '/listar/list_niv_aces';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}
