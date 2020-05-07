<?php
if (!isset($seg)) {
    exit;
}
$SendStsEditformEmail = filter_input(INPUT_POST, 'SendStsEditformEmail', FILTER_SANITIZE_STRING);

if($SendStsEditformEmail) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados_imagem_antiga = $dados['imagem_antiga'];
    unset($dados['imagem_antiga']);
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
        $dados['imagem'] = $dados_imagem_antiga;
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/editar/sts_edit_form_email';
        header("Location: $url_destino");
    } else {

        $result_edit_prod = "UPDATE sts_forms_emails SET
                titulo = '".$dados_validos['titulo']."',
                descricao = '".$dados_validos['descricao']."',
                titulo_botao= '".$dados_validos['titulo_botao']."',
                $campo_foto $valor_foto
                modified = NOW()
                WHERE id = '".$dados_validos['id']."' ";
       
       mysqli_query($conn, $result_edit_prod);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            include_once 'lib/lib_upload.php';                
            $destino = "../assets/imagens/form_email/" . $dados_validos['id'] . "/";
            $destino_apagar = $destino.$dados_imagem_antiga;
            apagarFoto($destino_apagar);
            upload($foto, $destino, 500, 400);

            $_SESSION['msg'] = "<div class='alert alert-success'>página Editada com sucesso</div>";
            $url_destino = pg.'/editar/sts_edit_form_email';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao editar a página</div>";
            $url_destino = pg.'/editar/sts_edit_form_email';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
