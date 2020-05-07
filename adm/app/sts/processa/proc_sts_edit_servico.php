<?php
if (!isset($seg)) {
    exit;
}
$SendStsEditServico = filter_input(INPUT_POST, 'SendStsEditServico', FILTER_SANITIZE_STRING);

if($SendStsEditServico) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os para Editar</div>";
    }

    if($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/editar/sts_edit_servico';
        header("Location: $url_destino");
    } else {

        $result_edit_car = "UPDATE sts_servicos SET
                titulo = '".$dados_validos['titulo']."',
                icone_um = '".$dados_validos['icone_um']."',
                nome_um = '".$dados_validos['nome_um']."',
                descricao_um = '".$dados_validos['descricao_um']."',
                icone_dois = '".$dados_validos['icone_dois']."',
                nome_dois = '".$dados_validos['nome_dois']."',
                descricao_dois = '".$dados_validos['descricao_dois']."',
                icone_tres = '".$dados_validos['icone_tres']."',
                nome_tres = '".$dados_validos['nome_tres']."',
                descricao_tres = '".$dados_validos['descricao_tres']."',
                modified = NOW()
                WHERE id = '".$dados_validos['id']."' ";
       mysqli_query($conn, $result_edit_car);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            $_SESSION['msg'] = "<div class='alert alert-success'>página de serviços Editada com sucesso</div>";
            $url_destino = pg.'/editar/sts_edit_servico';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>  Erro ao editar a página</div>";
            $url_destino = pg.'/processa/sts_edit_servico';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
