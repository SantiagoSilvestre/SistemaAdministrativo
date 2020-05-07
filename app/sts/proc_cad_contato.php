<?php

if (!isset($seguranca)) {
    exit;
}
$SendCadCont = filter_input(INPUT_POST, 'SendCadCont', FILTER_SANITIZE_STRING);
if ($SendCadCont) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //var_dump($dados);
    //Validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    include_once 'lib/lib_email.php';
    
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Necessário preencher todos os campos para enviar a mensagem!</div>";
    }    
    //Validar e-mail
    elseif (!validarEmail($dados_validos['email'])) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>E-mail inválido!</div>";
    }

    //Houve erro em algum campo será redirecionado para o formulário, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg . "/contato";
        header("Location: $url_destino");
    } else {
        $result_cont = "INSERT INTO sts_contatos
        (nome, email, assunto, mensagem, created) VALUES
        ('" . $dados_validos['nome'] . "', '" . $dados_validos['email'] . "', '" . $dados_validos['assunto'] . "','" . $dados_validos['mensagem'] . "', NOW())";

        mysqli_query($conn, $result_cont);
        if (mysqli_insert_id($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success' role='alert'>Mensagem enviada com sucesso!</div>";
            $url_destino = pg . "/contato";
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro ao enviar a mensagem tente mais tarde!</div>";
            $url_destino = pg . "/contato";
            header("Location: $url_destino");
        }
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Página inválida!</div>";
    $url_destino = pg . "/contato";
    header("Location: $url_destino");
}
