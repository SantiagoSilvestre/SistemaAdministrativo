<?php
if (!isset($seg)) {
    exit;
}
$SendCadArtigo = filter_input(INPUT_POST, 'SendCadArtigo', FILTER_SANITIZE_STRING);

if($SendCadArtigo) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados_res_pub = $dados['resumo_publico'];


    unset($dados['resumo_publico']);
    //validar campos vazios
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os campos</div>";
    } 

    if(empty($_FILES['imagem']['name'])) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>É necessário ter uma imagem</div>";
    } else {
        $foto = $_FILES['imagem'];
        include_once 'lib/lib_val_img_ext.php';
        if(!validarExtensao($foto['type'])) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'> Extensão da foto inválida</div>";
        }else {
            include_once 'lib/lib_caracter_esp.php';
            $foto['name'] = caracterEspecial($foto['name']);
        }
    }

    if($erro) {
        $dados['resumo_publico'] = $dados_res_pub;        
        $_SESSION['dados'] = $dados;        
        $url_destino = pg.'/cadastrar/sts_cad_artigo';
        header("Location: $url_destino");
    } else {

        $result_cad_pg = "INSERT INTO sts_artigos
         (titulo, descricao, conteudo, imagem, slug, keywords, description, author, resumo_publico, sts_robot_id, adms_usuario_id, sts_situacoe_id, sts_tps_artigo_id, sts_cats_artigo_id, created)
         VALUES ('".$dados_validos['titulo']."',
                    '".$dados_validos['descricao']."',
                    '".$dados_validos['conteudo']."',
                    '".$foto['name']."',
                    '".$dados_validos['slug']."',
                    '".$dados_validos['keywords']."',
                    '".$dados_validos['description']."',
                    '".$dados_validos['author']."',
                    '".$dados_res_pub."',
                    '".$dados_validos['sts_robot_id']."',
                    '".$dados_validos['adms_usuario_id']."',
                    '".$dados_validos['sts_situacoe_id']."',
                    '".$dados_validos['sts_tps_artigo_id']."',
                    '".$dados_validos['sts_cats_artigo_id']."',
                     NOW())";
        mysqli_query($conn, $result_cad_pg);
        
        if(mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);

            if(!empty($foto['name'])){
                include_once 'lib/lib_upload.php';
                $destino = "../assets/imagens/artigo/".mysqli_insert_id($conn)."/";
                upload($foto, $destino, 800, 600);
            }

            $_SESSION['msg'] = "<div class='alert alert-success'>Artigo Cadastrado</div>";
            $url_destino = pg.'/listar/sts_list_artigos';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>  Erro ao inserir o Artigo</div>";
            $url_destino = pg.'/cadastrar/sts_cad_artigo';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
