<?php
if (!isset($seg)) {
    exit;
}
$sendCadUser = filter_input(INPUT_POST, 'SendCadUser', FILTER_SANITIZE_STRING);

if(!empty($sendCadUser)) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados_apelido = $dados['apelido'];
    unset($dados['apelido'], $dados['imagem']);
    //validar campos vazios
    $erro = false;
    include_once 'lib/lib_vazio.php';
    include_once 'lib/lib_email.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os campos</div>";
    } else if(!validarEmail($dados_validos['email'])) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>E-mail inválido</div>";
    } else if((strlen($dados_validos['senha'])) < 6 ) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> A senha deve ter no mínimo 6 caracteres</div>";
    } else if(stristr($dados_validos['senha'], "'")) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Senha inválida</div>";
    }  else {
        // proibir cadastro de e-mail duplicado
        $result_user_email = "SELECT id FROM adms_usuarios WHERE email ='".$dados_validos['email']."' ";
        $resultado_user_email = mysqli_query($conn, $result_user_email);
        if(($resultado_user_email) && ($resultado_user_email->num_rows != 0 )){
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'> Esse E-mail já está cadastrado</div>";
        }

        // proibir cadastro duplicado de usuario
        $result_user_dup = "SELECT id FROM adms_usuarios WHERE usuario ='".$dados_validos['usuario']."' ";
        $resultado_user_dup = mysqli_query($conn, $result_user_dup);
        if(($resultado_user_dup) && ($resultado_user_dup->num_rows != 0 )){
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'> Esse Usuario já está cadastrado</div>";
        }
    }

    if(empty($_FILES['imagem']['name'])) {
        $campo_foto = "";
        $valor_foto = "";
    } else {
        $foto = $_FILES['imagem'];
        include_once 'lib/lib_val_img_ext.php';
        if(!validarExtensao($foto['type'])) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'> Extensão da foto inválida</div>";
        }else {
            include_once 'lib/lib_caracter_esp.php';
            $foto['name'] = caracterEspecial($foto['name']);
            $campo_foto = "imagem, ";
            $valor_foto = "'".$foto['name']."',";
        }
    }

    if($erro) {
        $dados['apelido'] = $dados_apelido;
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/cadastrar/cad_usuario';
        header("Location: $url_destino");
    } else {

        $dados_validos['senha'] = password_hash($dados_validos['senha'], PASSWORD_DEFAULT);

        $result_cad_user = "INSERT INTO adms_usuarios
         (nome, email, usuario, senha, $campo_foto adms_niveis_acesso_id, adms_sits_usuario_id, created)
         VALUES ('".$dados_validos['nome']."',
                    '".$dados_validos['email']."',
                    '".$dados_validos['usuario']."',
                    '".$dados_validos['senha']."',
                    $valor_foto
                    '".$dados_validos['adms_niveis_acesso_id']."', 
                    '".$dados_validos['adms_sits_usuario_id']."',
                     NOW())";
        mysqli_query($conn, $result_cad_user);
        if(mysqli_insert_id($conn)) {
            unset($dados);
            if(!empty($foto['name'])){
                include_once 'lib/lib_upload.php';
                $destino = "assets/imagens/usuario/".mysqli_insert_id($conn)."/";
                upload($foto, $destino, 200, 150);
            }
            
            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário Cadastrado com sucesso!</div>";
            $url_destino = pg.'/listar/list_usuario';
            header("Location: $url_destino");
        } else {
            $_SESSION['apelido'] = $dados_apelido;
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro o usuário não foi cadastrado com sucesso</div>";
            $url_destino = pg.'/cadastrar/cad_usuario';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
