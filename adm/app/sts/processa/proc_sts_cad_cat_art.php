<?php
if (!isset($seg)) {
    exit;
}
$SendStsCadCatArt = filter_input(INPUT_POST, 'SendStsCadCatArt', FILTER_SANITIZE_STRING);

if($SendStsCadCatArt) {

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
        $url_destino = pg.'/cadastrar/sts_cad_cat_art';
        header("Location: $url_destino");
    } else {

        $result_cad_cat = "INSERT INTO sts_cats_artigos
         (nome, sts_situacoe_id, created)
         VALUES ('".$dados_validos['nome']."',
                    '".$dados_validos['sts_situacoe_id']."',
                     NOW())";
        mysqli_query($conn, $result_cad_cat);
        
        if(mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);

            $_SESSION['msg'] = "<div class='alert alert-success'>Categoria cadastrada</div>";
            $url_destino = pg.'/listar/sts_list_cat_artigo';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro ao cadastrar categoria</div>";
            $url_destino = pg.'/cadastrar/sts_cad_cat_art';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
