<?php
if (!isset($seg)) {
    exit;
}

$SendStsEditPerResp = filter_input(INPUT_POST, 'SendStsEditPerResp', FILTER_SANITIZE_STRING);

if($SendStsEditPerResp) {

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
        $url_destino = pg.'/editar/sts_edit_per_resp?id='.$dados['id'];
        header("Location: $url_destino");
    } else {

        $result_edit_prod = "UPDATE sts_pergs_resps SET
                pergunta = '".$dados_validos['pergunta']."',
                resposta = '".$dados_validos['resposta']."',
                sts_situacoe_id = '".$dados_validos['sts_situacoe_id']."',
                modified = NOW()
                WHERE id = '".$dados_validos['id']."' ";
       echo $result_edit_prod;
       mysqli_query($conn, $result_edit_prod);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            $_SESSION['msg'] = "<div class='alert alert-success'>FAQ Editada com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_perg_resp';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao editar o FAQ</div>";
            $url_destino = pg.'/listar/sts_list_perg_resp';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
