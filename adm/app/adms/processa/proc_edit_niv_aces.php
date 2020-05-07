<?php
if (!isset($seg)) {
    exit;
}
$sendEditNivAc = filter_input(INPUT_POST, 'SendEditNivAc', FILTER_SANITIZE_STRING);

if($sendEditNivAc) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $erro = false ;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para Editar <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button></div>";
    }

    if($erro) {
        $url_destino = pg.'/editar/edit_niv_aces?id='.$dados['id']  ;
        header("Location: $url_destino");
    } else {
        $result_niv_ac = "UPDATE adms_niveis_acesso SET 
                            nome = '".$dados_validos['nome_niv_aces']."', 
                            modified = NOW()
                            WHERE id = '".$dados_validos['id']."' "; 
        mysqli_query($conn, $result_niv_ac);
        if(mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'> Alterado com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
            $url_destino = pg.'/listar/list_niv_aces';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro ao editar o nível de acesso<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button></div>";
            $url_destino = pg.'/editar/edit_niv_aces?id='.$dados['id']  ;
            header("Location: $url_destino");
        }
    }


} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
