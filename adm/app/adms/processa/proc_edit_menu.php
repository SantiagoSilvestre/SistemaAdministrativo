<?php
if (!isset($seg)) {
    exit;
}
$sendEditMen = filter_input(INPUT_POST, 'SendEditMen', FILTER_SANITIZE_STRING);

if($sendEditMen) {

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
        $dados['obs'] = trim($dados_obs);
        $dados['icone'] = $dados_icone;
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/editar/edit_menu?id='.$dados['id'];
        header("Location: $url_destino");
    } else {

        $result_upd_pg = "UPDATE adms_menu SET 
                            nome = '".$dados_validos['nome']."',
                            icone = '".$dados_validos['icone']."',
                            adms_sit_id = '".$dados_validos['adms_sit_id']."',
                            modified = NOW()
                            WHERE id = '".$dados_validos['id']."'";
       $resultado_upd_pg = mysqli_query($conn, $result_upd_pg);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>Menu Editado com sucesso</div>";
            $url_destino = pg.'/listar/list_menu';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>  Erro ao editar a Menu</div>";
            $url_destino = pg.'/editar/edit_menu?id'.$dados['id'];
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
