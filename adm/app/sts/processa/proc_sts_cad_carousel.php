<?php
if (!isset($seg)) {
    exit;
}
$SendStsCadCarousel = filter_input(INPUT_POST, 'SendStsCadCarousel', FILTER_SANITIZE_STRING);

if($SendStsCadCarousel) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados_titulo = $dados['titulo'];
    $dados_descricao = $dados['descricao'];
    $dados_posicao_text = $dados['posicao_text'];
    $dados_titulo_botao = $dados['titulo_botao'];
    $dados_link = $dados['link'];
    $dados_sts_cor_id = $dados['sts_cor_id'];


    unset($dados['titulo'], $dados['descricao'], $dados['posicao_text'], $dados['titulo_botao'], $dados['link'], $dados['sts_cor_id']);
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
        $dados['titulo'] = $dados_titulo;
        $dados['descricao'] = $dados_descricao;
        $dados['posicao_text'] = $dados_posicao_text;
        $dados['titulo_botao'] = $dados_titulo_botao;
        $_SESSION['dados'] = $dados;
        $dados['link'] = $dados_link;
        $dados['sts_cor_id'] = $dados_sts_cor_id;
        $url_destino = pg.'/cadastrar/sts_cad_carousel';
        header("Location: $url_destino");
    } else {

        //Pesquisar o maior numero da ordem na tabela
        $result_maior_ordem = "SELECT ordem FROM sts_carousels ORDER BY ordem desc LIMIT 1";
        $resultado_ordem_maior = mysqli_query($conn, $result_maior_ordem);
        $maior_ordem = mysqli_fetch_assoc($resultado_ordem_maior);
        $ordem = $maior_ordem['ordem'] +1;

        $result_cad_pg = "INSERT INTO sts_carousels
         (nome, imagem, titulo, descricao, posicao_text, titulo_botao, link, ordem, sts_cor_id, sts_situacoe_id, created)
         VALUES ('".$dados_validos['nome']."',
                    '".$foto['name']."',
                    '".$dados_titulo."',
                    '".$dados_descricao."',
                    '".$dados_posicao_text."',
                    '".$dados_titulo_botao."',
                    '".$dados_link."',
                    '".$ordem."',
                    '".$dados_sts_cor_id."',
                    '".$dados_validos['sts_situacoe_id']."',
                     NOW())";
        mysqli_query($conn, $result_cad_pg);
        
        if(mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);

            if(!empty($foto['name'])){
                include_once 'lib/lib_upload.php';
                $destino = "../assets/imagens/carousel/".mysqli_insert_id($conn)."/";
                upload($foto, $destino, 1920, 846);
            }

            $_SESSION['msg'] = "<div class='alert alert-success'>Carousel Cadastrado</div>";
            $url_destino = pg.'/listar/sts_list_carousels';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao inserir o Carousel</div>";
            $url_destino = pg.'/cadastrar/sts_cad_carousel';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
