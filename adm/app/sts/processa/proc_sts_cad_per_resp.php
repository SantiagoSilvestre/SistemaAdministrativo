<?php
if (!isset($seg)) {
    exit;
}
$SendStsCadPerResp = filter_input(INPUT_POST, 'SendStsCadPerResp', FILTER_SANITIZE_STRING);

if($SendStsCadPerResp) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //validar campos vazios
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os campos</div>";
    } 

    if($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/cadastrar/sts_cad_per_resp';
        header("Location: $url_destino");
    } else {

        $result_cad_per_resp = "INSERT INTO sts_pergs_resps
         (pergunta, resposta, sts_situacoe_id, created)
         VALUES ('".$dados_validos['pergunta']."',
                    '".$dados_validos['resposta']."',
                    '".$dados_validos['sts_situacoe_id']."',
                     NOW())";
        mysqli_query($conn, $result_cad_per_resp);
        
        if(mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);

            $_SESSION['msg'] = "<div class='alert alert-success'>FAQ Cadastrado</div>";
            $url_destino = pg.'/listar/sts_list_perg_resp';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro ao inserir o FAQ</div>";
            $url_destino = pg.'/cadastrar/sts_cad_per_resp';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
