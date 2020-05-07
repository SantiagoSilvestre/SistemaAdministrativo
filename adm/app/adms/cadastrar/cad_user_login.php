<?php
if (!isset($seg)) {
    exit;
}

$SendCadLogin = filter_input(INPUT_POST, 'SendCadLogin', FILTER_SANITIZE_STRING);
if (!empty($SendCadLogin)) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $erro = false;
    include_once 'lib/lib_vazio.php';
    include_once 'lib/lib_email.php';
    $dados_validos = vazio($dados);
    $_SESSION['dados'] = $dados;
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert-danger'> Necessário preencher todos os campos para cadastrar o usuário!</div>";
    } else if (!validarEmail($dados_validos['email'])){
        $erro = true;
        $_SESSION['msg'] = "<div class='alert-danger'> E-mail inválido</div>";
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

        if(!$erro) {
            $dados_validos['senha'] = password_hash($dados_validos['senha'], PASSWORD_DEFAULT);

            $result_user_perm = "SELECT * FROM adms_cads_usuarios LIMIT 1";
            $resultado_user_perm = mysqli_query($conn, $result_user_perm);
            $row_user_perm = mysqli_fetch_assoc($resultado_user_perm);

            $result_cad_user = "INSERT INTO adms_usuarios
             (nome, email, usuario, senha, adms_niveis_acesso_id, adms_sits_usuario_id, created)
             VALUES ('".$dados_validos['nome']."',
                        '".$dados_validos['email']."',
                        '".$dados_validos['usuario']."',
                        '".$dados_validos['senha']."',
                        '".$row_user_perm['adms_niveis_acesso_id']."', 
                        '".$row_user_perm['adms_sits_usuario_id']."',
                         NOW())";
            mysqli_query($conn, $result_cad_user);
            if(mysqli_insert_id($conn)) {
                unset($_SESSION['dados']);
                $_SESSION['msgcad'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
                $url_destino = pg.'/acesso/login';
                header("location: $url_destino");
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário não foi cadastrado</div>";
                $url_destino = pg.'/acesso/cad_user_login';
                header("location: $url_destino");
            }
        }

    }
}
include_once 'app/adms/include/head_login.php';
?>
<body class="text-center">
    <form class="form-signin" method="POST" action="">
       <h1 class="h3 mb-3 font-weight-normal">Novo Cadastro</h1>
        <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <div class="form-group">
            <label>Nome</label>
            <input name="nome" type="text" class="form-control" placeholder="Nome completo" value="<?php if(isset($_SESSION['dados']['nome'])) { echo $_SESSION['dados']['nome']; } ?>" require>               
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input name="email" type="email" class="form-control" placeholder="Seu melhor e-mail" value="<?php if(isset($_SESSION['dados']['email'])) { echo $_SESSION['dados']['email']; } ?>"required>               
        </div>
        <div class="form-group">
            <label>Usuário</label>
            <input name="usuario" type="text" class="form-control" placeholder="Nome do usuário" value="<?php if(isset($_SESSION['dados']['usuario'])) { echo $_SESSION['dados']['usuario']; } ?>" required>               
        </div>
        <div class="form-group">
            <label>Senha</label>
            <input name="senha" type="password" class="form-control" placeholder="A senha deve ter no mínimo 6 caracteres" value="<?php if(isset($_SESSION['dados']['senha'])) { echo $_SESSION['senha']; } ?>" required>               
        </div>
        <input type="submit" class="btn btn-lg btn-success btn-block" value="Cadastrar" name="SendCadLogin">
        <p class="text-center">Lembrou?<a href="<?= pg.'/acesso/login' ?>">Clique aqui</a> para logar</p>
    </form>
    <?php
        unset($_SESSION['dados']);
    ?>
</body>
