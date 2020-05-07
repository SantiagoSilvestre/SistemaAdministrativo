<?php
if (!isset($seg)) {
    exit;
}
$SendStsEdiSobEmp = filter_input(INPUT_POST, 'SendStsEdiSobEmp', FILTER_SANITIZE_STRING);

if($SendStsEdiSobEmp) {

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
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/editar/sts_edit_sob_emp?id='.$dados['id'];
        header("Location: $url_destino");
    } else {

        $result_edit_sob_emp = "UPDATE sts_sobs_emps SET
                titulo = '".$dados_validos['titulo']."',
                descricao = '".$dados_validos['descricao']."',
                $campo_foto $valor_foto
                sts_situacoe_id = '".$dados_validos['sts_situacoe_id']."',
                modified = NOW()
                WHERE id = '".$dados_validos['id']."' ";
       mysqli_query($conn, $result_edit_sob_emp);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            include_once 'lib/lib_upload.php';                
            $destino = "../assets/imagens/sob_emp/" . $dados_validos['id'] . "/";
            $destino_apagar = $destino.$dados_imagem_antiga;
            apagarFoto($destino_apagar);
            upload($foto, $destino, 600, 400);

            $_SESSION['msg'] = "<div class='alert alert-success'>página Editada com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_sob_emp';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao editar a página</div>";
            $url_destino = pg.'/processa/sts_edit_sob_emp?id'.$dados['id'];
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
