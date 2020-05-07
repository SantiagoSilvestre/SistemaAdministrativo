<?php
if (!isset($seg)) {
    exit;
}
$SendEditCadUser = filter_input(INPUT_POST, 'SendEditCadUser', FILTER_SANITIZE_STRING);

if($SendEditCadUser) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //validar campos vazios
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os para Editar</div>";
   
    }

    if($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/editar/edit_cad_user_login';
        header("Location: $url_destino");
    } else {

        $result_upd_pg = "UPDATE adms_cads_usuarios SET 
                            adms_niveis_acesso_id = '".$dados_validos['adms_niveis_acesso_id']."',
                            adms_sits_usuario_id = '".$dados_validos['adms_sits_usuario_id']."',
                            modified = NOW()
                            WHERE id = '1'";
       $resultado_upd_pg = mysqli_query($conn, $result_upd_pg);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>Formulário cadastrar usuário Editado com sucesso</div>";
            $url_destino = pg.'/editar/edit_cad_user_login';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>  Erro ao editar o formulário cadastrar usuário</div>";
            $url_destino = pg.'/editar/edit_cad_user_login';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
