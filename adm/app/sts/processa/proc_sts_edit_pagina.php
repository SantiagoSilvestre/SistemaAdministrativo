<?php
if (!isset($seg)) {
    exit;
}
$sendEditPg = filter_input(INPUT_POST, 'SendStsEditPg', FILTER_SANITIZE_STRING);

if($sendEditPg) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados_obs = $dados['obs'];
    $dados_imagem_antiga = $dados['imagem_antiga'];
    unset($dados['obs'], $dados['imagem_antiga']);
    //validar campos vazios
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os para Editar</div>";
    } else {
        // proibir cadastro duplicado
        $result_pg = "SELECT id FROM sts_paginas 
                        WHERE endereco ='".$dados_validos['endereco']."' 
                        AND sts_tps_pgs_id = '".$dados_validos['sts_tps_pgs_id']."'
                        AND id <> '".$dados['id']."' ";
        $resultado_pg = mysqli_query($conn, $result_pg);
        if(($resultado_pg) && ($resultado_pg->num_rows != 0 )){
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'> Esse endereço já está cadastrado</div>";
        }
    }

    //Criar as variaveis da foto quando a mesma não está sendo cadastrada
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
        $dados['obs'] = trim($dados_obs);
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/editar/sts_edit_pagina?id='.$dados['id'];
        header("Location: $url_destino");
    } else {

        $result_upd_pg = "UPDATE sts_paginas SET 
                            endereco = '".$dados_validos['endereco']."',
                            nome_pagina = '".$dados_validos['nome_pagina']."',
                            titulo = '".$dados_validos['titulo']."',
                            obs = '".$dados_obs."',
                            keywords = '".$dados_validos['keywords']."',
                            description = '".$dados_validos['description']."',
                            author = '".$dados_validos['author']."',
                            $campo_foto  $valor_foto
                            lib_bloq = '".$dados_validos['lib_bloq']."',
                            depend_pg = '".$dados_validos['depend_pg']."',
                            sts_tps_pgs_id = '".$dados_validos['sts_tps_pgs_id']."',
                            sts_robot_id = '".$dados_validos['sts_robot_id']."',
                            sts_situacaos_pg_id = '".$dados_validos['sts_situacaos_pg_id']."',
                            modified = NOW()
                            WHERE id = '".$dados_validos['id']."'";
       $resultado_upd_pg = mysqli_query($conn, $result_upd_pg);

       if (!empty($foto['name'])) {
        include_once 'lib/lib_upload.php';                
        $destino = "../assets/imagens/paginas/" . $dados['id'] . "/";
        $destino_apagar = $destino.$dados_imagem_antiga;
        apagarFoto($destino_apagar);
        upload($foto, $destino, 1200, 627);
        }

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>página STS Editada com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_pagina';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro ao editar a página STS</div>";
            $url_destino = pg.'/processa/sts_edit_pagina?id'.$dados['id'];
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
