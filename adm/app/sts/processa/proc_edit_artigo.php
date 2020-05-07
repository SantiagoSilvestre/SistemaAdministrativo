<?php
if (!isset($seg)) {
    exit;
}
$SendEditArtigo = filter_input(INPUT_POST, 'SendEditArtigo', FILTER_SANITIZE_STRING);

if($SendEditArtigo) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados_resumo = $dados['resumo_publico'];
    $dados_imagem_antiga = $dados['imagem_antiga'];
    unset($dados['resumo_publico']);
    //validar campos vazios
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os para Editar</div>";
    }

    if (empty($_FILES['imagem']['name'])) {
        $campo_foto = "";
        $valor_foto = "";
    } else {
        $foto = $_FILES['imagem'];
        include_once 'lib/lib_val_img_ext.php';
        if (!validarExtensao($foto['type'])) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>Extensão da foto inválida!</div>";
        } else {
            include_once 'lib/lib_caracter_esp.php';
            $foto['name'] = caracterEspecial($foto['name']);
            $campo_foto = "imagem = ";
            $valor_foto = "'" . $foto['name'] . "',";
        }
    }

    if($erro) {
        $dados['resumo_publico'] = $dados_resumo;
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/editar/sts_edit_artigo?id='.$dados['id'];
        header("Location: $url_destino");
    } else {

        $result_edit_car = "UPDATE sts_artigos SET
                titulo = '".$dados_validos['titulo']."',
                descricao = '".$dados_validos['descricao']."',
                conteudo = ' ".$dados_validos['conteudo']." ',
                $campo_foto $valor_foto
                slug	 = '".$dados_validos['slug']."',
                keywords = '".$dados_validos['keywords']."',
                description = '".$dados_validos['description']."',
                author = '".$dados_validos['author']."',
                resumo_publico = '".$dados_resumo."',
                sts_robot_id = '".$dados_validos['sts_robot_id']."',
                adms_usuario_id = '".$dados_validos['adms_usuario_id']."',
                sts_situacoe_id = '".$dados_validos['sts_situacoe_id']."',
                sts_tps_artigo_id = '".$dados_validos['sts_tps_artigo_id']."',
                sts_cats_artigo_id	 = '".$dados_validos['sts_cats_artigo_id']."',
                modified = NOW()
                WHERE id = '".$dados_validos['id']."' ";
       mysqli_query($conn, $result_edit_car);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            include_once 'lib/lib_upload.php';                
            $destino = "../assets/imagens/artigo/" . $dados_validos['id'] . "/";
            $destino_apagar = $destino.$dados_imagem_antiga;
            apagarFoto($destino_apagar);
            upload($foto, $destino, 1920, 846);

            $_SESSION['msg'] = "<div class='alert alert-success'>página Editada com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_artigos';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao editar a página</div>";
            $url_destino = pg.'/processa/sts_edit_artigo?id'.$dados['id'];
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
