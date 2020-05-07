<?php
if (!isset($seg)) {
    exit;
}

$SendStsEditBlog = filter_input(INPUT_POST, 'SendStsEditBlog', FILTER_SANITIZE_STRING);

if($SendStsEditBlog) {

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
        $url_destino = pg.'/editar/sts_edit_blog_sob';
        header("Location: $url_destino");
    } else {

        $result_edit_blog = "UPDATE sts_blogs_sobres SET
                titulo = '".$dados_validos['titulo']."',
                descricao = '".$dados_validos['descricao']."',
                sts_situacoe_id = '".$dados_validos['sts_situacoe_id']."',
                modified = NOW()
                WHERE id = '".$dados_validos['id']."' ";
       echo $result_edit_blog;
       mysqli_query($conn, $result_edit_blog);

        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            $_SESSION['msg'] = "<div class='alert alert-success'>Blog Sobre Editada com sucesso</div>";
            $url_destino = pg.'/editar/sts_edit_blog_sob';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro ao editar o Blog Sobre</div>";
            $url_destino = pg.'/editar/sts_edit_blog_sob';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
