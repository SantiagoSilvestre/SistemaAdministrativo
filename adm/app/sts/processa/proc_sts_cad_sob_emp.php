<?php
if (!isset($seg)) {
    exit;
}
$SendStsCadSobEmp = filter_input(INPUT_POST, 'SendStsCadSobEmp', FILTER_SANITIZE_STRING);

if($SendStsCadSobEmp) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    //validar campos vazios
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os para Editar</div>";
    }

    if (empty($_FILES['imagem']['name'])) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Foto Não pode ser vazia</div>";
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
        $url_destino = pg.'/cadastrar/sts_cad_sob_emp';
        header("Location: $url_destino");
    } else {

        $resul_or = "SELECT ordem FROM sts_sobs_emps ORDER BY ordem DESC LIMIT 1 ";

        $resultado_or = mysqli_query($conn, $resul_or);
        $row = mysqli_fetch_assoc($resultado_or);
        $ordem = $row['ordem'] + 1;

        $result_cad_pg = "INSERT INTO sts_sobs_emps
         (titulo, descricao, imagem, ordem, sts_situacoe_id, created)
         VALUES ('".$dados_validos['titulo']."',
                    '".$dados_validos['descricao']."',
                    '".$foto['name']."',
                    '".$ordem."',
                    '".$dados_validos['sts_situacoe_id']."',
                     NOW())";
        mysqli_query($conn, $result_cad_pg);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            include_once 'lib/lib_upload.php';                
            $destino = "../assets/imagens/sob_emp/" .mysqli_insert_id($conn) . "/";
            upload($foto, $destino, 800, 600);

            $_SESSION['msg'] = "<div class='alert alert-success'>página Cadastrada com sucesso</div>";
            $url_destino = pg.'/listar/sts_list_sob_emp';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao editar a página</div>";
            $url_destino = pg.'/cadastrar/sts_cad_sob_emp';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
