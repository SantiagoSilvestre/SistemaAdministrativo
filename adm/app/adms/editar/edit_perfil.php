<?php
if (!isset($seg)) {
    exit;
}
include_once 'app/adms/include/head.php';

        $result_user = "SELECT u.*, s.nome as nome_sit, c.cor as nome_cor, niv_ac.nome as nome_niv_ac
        FROM adms_usuarios u
        INNER JOIN adms_sits_usuarios s ON u.adms_sits_usuario_id = s.id
        INNER JOIN adms_cors c ON s.adms_cor_id = c.id
        INNER JOIN adms_niveis_acesso niv_ac on niv_ac.id=u.adms_niveis_acesso_id
        WHERE u.id = '".$_SESSION['id']."' LIMIT 1"; 

    $resultado_edit_user = mysqli_query($conn, $result_user);
    //Verificar se encontrou a página no banco de dados
    if (($resultado_edit_user) AND ( $resultado_edit_user->num_rows != 0)) {
        $row_edit_user = mysqli_fetch_assoc($resultado_edit_user);
        ?>
        <body>
            <?php
            include_once 'app/adms/include/header.php';
            ?>
            <div class="d-flex">
                <?php
                include_once 'app/adms/include/menu.php';
                ?>

                <div class="content p-1">
                    <div class="list-group-item">
                        <div class="d-flex">
                            <div class="mr-auto p-2">
                                <h2 class="display-4 titulo">Editar Perfil</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_vis = carregarBtn('visualizar/vis_perfil', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/vis_perfil' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    
                                    ?>
                                </span>
                            </div>
                        </div><hr>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_perfil" enctype="multipart/form-data">  

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>                                
                                        <span class="text-danger">*</span> Nome
                                    </label>
                                    <input name="nome" type="text" class="form-control" id="nome" placeholder="Nome do usuário completo" value="<?php
                                    if (isset($_SESSION['dados']['nome'])) {
                                        echo $_SESSION['dados']['nome'];
                                    } elseif (isset($row_edit_user['nome'])) {
                                        echo $row_edit_user['nome'];
                                    }
                                    ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <label><span class="text-danger">*</span> E-mail</label>
                                    <input name="email" type="email" class="form-control" id="email" placeholder="O melhor e-mail do usuário" value="<?php
                                    if (isset($_SESSION['dados']['email'])) {
                                        echo $_SESSION['dados']['email'];
                                    } elseif (isset($row_edit_user['email'])) {
                                        echo $row_edit_user['email'];
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label>                                
                                        <span class="text-danger">*</span> Usuário
                                    </label>
                                    <input name="usuario" type="text" class="form-control" id="nome" placeholder="Nome de usuário para login" value="<?php
                                    if (isset($_SESSION['dados']['usuario'])) {
                                        echo $_SESSION['dados']['usuario'];
                                    } elseif (isset($row_edit_user['usuario'])) {
                                        echo $row_edit_user['usuario'];
                                    }
                                    ?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Senha</label>
                                    <input name="senha" type="password" class="form-control" id="email" placeholder="A senha deve ter 6 caracteres" value="<?php
                                    if (isset($_SESSION['dados']['senha'])) {
                                        echo $_SESSION['dados']['senha'];
                                    }
                                    ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label> Apelido </label>
                                    <input name="apelido" type="text" class="form-control" id="email" placeholder="Apelido do usuário" value="<?php
                                    if (isset($_SESSION['dados']['apelido'])) {
                                        echo $_SESSION['dados']['apelido'];
                                    } elseif (isset($row_edit_user['apelido'])) {
                                        echo $row_edit_user['apelido'];
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <input type="hidden" name="imagem_antiga" value="<?php echo $row_edit_user['imagem']; ?>">
                                <div class="form-group col-md-6">
                                    <label> Foto </label>
                                    <input type="file" name="imagem" onchange="previewImagem();">
                                </div>  
                                <div class="form-group col-md-6">
                                    <?php
                                    if (isset($row_edit_user['imagem'])) {
                                        $imagem_antiga = pg . '/assets/imagens/usuario/'.$row_edit_user['id'].'/'.$row_edit_user['imagem'];
                                    }else{
                                       $imagem_antiga  = pg.'/assets/imagens/preview.png'; 
                                    }
                                    ?>
                                    <img src="<?php echo $imagem_antiga; ?>" id="preview-user" class="img-thumbnail" style="width: 150px; height: 150px;">
                                </div>                       
                            </div>

                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditPerfil" type="submit" class="btn btn-warning" value="Salvar">
                        </form>
                    </div>    
                </div>

                <?php
                include_once 'app/adms/include/rodape_lib.php';
                ?>
                <script>
                    function previewImagem() {
                        var imagem = document.querySelector('input[name=imagem').files[0];
                        var preview = document.querySelector('#preview-user');

                        var reader = new FileReader();

                        reader.onloadend = function () {
                            preview.src = reader.result;
                        }

                        if (imagem) {
                            reader.readAsDataURL(imagem);
                        } else {
                            preview.src = "";
                        }
                    }
                </script>  
            </div>
        </body>
        <?php
        unset($_SESSION['dados']);
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
        $url_destino = pg . '/visualizar/vis_perfil';
        header("Location: $url_destino");
    }
