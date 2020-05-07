<?php
if (!isset($seg)) {
    exit;
}
$SendStsEditCarousel = filter_input(INPUT_POST, 'SendStsEditCarousel', FILTER_SANITIZE_STRING);

if($SendStsEditCarousel) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados_titulo = $dados['titulo'];
    $dados_descricao = $dados['descricao'];
    $dados_posicao_text = $dados['posicao_text'];
    $dados_titulo_botao = $dados['titulo_botao'];
    $dados_link = $dados['link'];
    $dados_sts_cor_id = $dados['sts_cor_id'];
    $dados_imagem_antiga = $dados['imagem_antiga'];
    unset($dados['titulo'], $dados['descricao'], $dados['posicao_text'], $dados['titulo_botao'], $dados['link'], $dados['sts_cor_id']);
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
        $dados['titulo'] = $dados_titulo;
        $dados['descricao'] = $dados_descricao;
        $dados['posicao_text'] = $dados_posicao_text;
        $dados['titulo_botao'] = $dados_titulo_botao;
        $_SESSION['dados'] = $dados;
        $dados['link'] = $dados_link;
        $dados['sts_cor_id'] = $dados_sts_cor_id;
        $url_destino = pg.'/editar/sts_edit_carousel?id='.$dados['id'];
        header("Location: $url_destino");
    } else {

        $result_edit_car = "UPDATE sts_carousels SET
                nome = '".$dados_validos['nome']."',
                $campo_foto $valor_foto
                titulo = '".$dados_titulo."',
                descricao = '".$dados_descricao."',
                posicao_text = '".$dados_posicao_text."',
                titulo_botao = '".$dados_titulo_botao."',
                link = '".$dados_link."',
                sts_cor_id = '".$dados_sts_cor_id."',
                sts_situacoe_id = '".$dados_validos['sts_situacoe_id']."',
                modified = NOW()
                WHERE id = '".$dados_validos['id']."' ";
       mysqli_query($conn, $result_edit_car);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            include_once 'lib/lib_upload.php';                
            $destino = "../assets/imagens/carousel/" . $dados_validos['id'] . "/";
            $destino_apagar = $destino.$dados_imagem_antiga;
            apagarFoto($destino_apagar);
            upload($foto, $destino, 1920, 846);

            $_SESSION['msg'] = "<div class='alert alert-success'>página Editada com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_carousels';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao editar a página</div>";
            $url_destino = pg.'/processa/sts_edit_carousel?id'.$dados['id'];
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
