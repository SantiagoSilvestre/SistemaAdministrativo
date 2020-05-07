<?php
if (!isset($seg)) {
    exit;
}
$sendCadNivAc = filter_input(INPUT_POST, 'SendCadNivAc', FILTER_SANITIZE_STRING);

if($sendCadNivAc) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $erro = false ;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para Cadastro <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button></div>";
    }

    if($erro) {
        $url_destino = pg.'/cadastrar/cad_niv_aces';
        header("Location: $url_destino");
    } else {

        $result_ordem = "SELECT ordem FROM adms_niveis_acesso ORDER BY ID DESC LIMIT 1";
        $resultado_ordem = mysqli_query($conn, $result_ordem);
        $resultado = mysqli_fetch_assoc($resultado_ordem);
        $resultado = $resultado['ordem'] + 1;
        $result_niv_ac = "INSERT INTO adms_niveis_acesso (nome, ordem, created) VALUES ('".$dados_validos['nome_niv_aces']."', '".$resultado."', NOW() ) "; 
        mysqli_query($conn, $result_niv_ac);
        if(mysqli_insert_id($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'> Inserido com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button></div>";
            $url_destino = pg.'/listar/list_niv_aces';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro ao inserir o nível de acesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button></div>";
            $url_destino = pg.'/cadastrar/cad_niv_aces';
            header("Location: $url_destino");
        }
    }


} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
