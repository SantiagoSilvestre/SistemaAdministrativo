<?php
if (!isset($seg)) {
    exit;
}

$SendStsEditContato = filter_input(INPUT_POST, 'SendStsEditContato', FILTER_SANITIZE_STRING);

if($SendStsEditContato) {

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
        $url_destino = pg.'/editar/sts_edit_contato?id='.$dados['id'];
        header("Location: $url_destino");
    } else {

        $result_edit_prod = "UPDATE sts_contatos SET
                nome = '".$dados_validos['nome']."',
                email = '".$dados_validos['email']."',
                assunto = '".$dados_validos['assunto']."',
                mensagem = '".$dados_validos['mensagem']."',
                modified = NOW()
                WHERE id = '".$dados_validos['id']."' ";
       echo $result_edit_prod;
       mysqli_query($conn, $result_edit_prod);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            $_SESSION['msg'] = "<div class='alert alert-success'>Mensagem Editada com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_contato';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao editar a Mensagem</div>";
            $url_destino = pg.'/listar/sts_list_contato';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
