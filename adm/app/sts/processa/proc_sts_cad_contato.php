<?php
if (!isset($seg)) {
    exit;
}
$SendStsCadContato = filter_input(INPUT_POST, 'SendStsCadContato', FILTER_SANITIZE_STRING);

if($SendStsCadContato) {

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
        $url_destino = pg.'/cadastrar/sts_cad_contato';
        header("Location: $url_destino");
    } else {

        $result_cad_per_resp = "INSERT INTO sts_contatos
         (nome, email, assunto, mensagem, created)
         VALUES ('".$dados_validos['nome']."',
                    '".$dados_validos['email']."',
                    '".$dados_validos['assunto']."',
                    '".$dados_validos['mensagem']."',
                     NOW())";
        mysqli_query($conn, $result_cad_per_resp);
        
        if(mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);

            $_SESSION['msg'] = "<div class='alert alert-success'>Mensagem Cadastrada</div>";
            $url_destino = pg.'/listar/sts_list_contato';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro ao inserir a Mensagem</div>";
            $url_destino = pg.'/cadastrar/sts_cad_contato';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
