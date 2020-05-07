<?php
if (!isset($seg)) {
    exit;
}

    $result_edit_caduser = "SELECT * FROM adms_cads_usuarios WHERE id='1' LIMIT 1";
    

$resultado_edit_caduser = mysqli_query($conn, $result_edit_caduser);
//Verificar se encontrou a página no banco de dados
if (($resultado_edit_caduser) AND ( $resultado_edit_caduser->num_rows != 0)) {
    $row_edit_caduser = mysqli_fetch_assoc($resultado_edit_caduser);
    include_once 'app/adms/include/head.php';
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
                            <h2 class="display-4 titulo">Editar formulário cadastrar usuário</h2>
                        </div>
                    </div><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <form method="POST" action="<?php echo pg; ?>/processa/proc_cad_user_login" enctype="multipart/form-data">  
                        <input type="hidden" name="id" value="<?php
                        if (isset($row_edit_caduser['id'])) {
                            echo $row_edit_caduser['id'];
                        }
                        ?>">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <?php
                                $result_niv_ac = "SELECT id, nome FROM adms_niveis_acesso WHERE ordem >= '".$_SESSION['ordem']."' ORDER BY nome ASC";
                                $resultado_niv_ac = mysqli_query($conn, $result_niv_ac);
                                ?>
                                <label><span class="text-danger">*</span> Nível de Acesso </label>
                                <select name="adms_niveis_acesso_id" id="adms_niveis_acesso_id" class="form-control">
                                    <option value="">Selecione</option>
                                    <?php
                                    while ($row_niv_ac = mysqli_fetch_assoc($resultado_niv_ac)) {
                                        if (isset($_SESSION['dados']['adms_niveis_acesso_id']) AND ( $_SESSION['dados']['adms_niveis_acesso_id'] == $row_niv_ac['id'])) {
                                            echo "<option value='" . $row_niv_ac['id'] . "' selected>" . $row_niv_ac['nome'] . "</option>";
                                            //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                        } elseif (!isset($_SESSION['dados']['adms_niveis_acesso_id']) AND ( isset($row_edit_caduser['adms_niveis_acesso_id']) AND ( $row_edit_caduser['adms_niveis_acesso_id'] == $row_niv_ac['id']))) {
                                            echo "<option value='" . $row_niv_ac['id'] . "' selected>" . $row_niv_ac['nome'] . "</option>";
                                        } else {
                                            echo "<option value='" . $row_niv_ac['id'] . "'>" . $row_niv_ac['nome'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <?php
                                $result_sit_user = "SELECT id, nome FROM adms_sits_usuarios ORDER BY nome ASC";
                                $resultado_sit_user = mysqli_query($conn, $result_sit_user);
                                ?>
                                <label><span class="text-danger">*</span> Situação do Usuário </label>
                                <select name="adms_sits_usuario_id" id="adms_sits_usuario_id" class="form-control">
                                    <option value="">Selecione</option>
                                    <?php
                                    while ($row_sit_user = mysqli_fetch_assoc($resultado_sit_user)) {
                                        if (isset($_SESSION['dados']['adms_sits_usuario_id']) AND ( $_SESSION['dados']['adms_sits_usuario_id'] == $row_sit_user['id'])) {
                                            echo "<option value='" . $row_sit_user['id'] . "' selected>" . $row_sit_user['nome'] . "</option>";
                                            //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                        } elseif (!isset($_SESSION['dados']['adms_sits_usuario_id']) AND ( isset($row_edit_caduser['adms_sits_usuario_id']) AND ( $row_edit_caduser['adms_sits_usuario_id'] == $row_sit_user['id']))) {
                                            echo "<option value='" . $row_sit_user['id'] . "' selected>" . $row_sit_user['nome'] . "</option>";
                                        } else {
                                            echo "<option value='" . $row_sit_user['id'] . "'>" . $row_sit_user['nome'] . "</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <p>
                            <span class="text-danger">* </span>Campo obrigatório
                        </p>
                        <input name="SendEditCadUser" type="submit" class="btn btn-warning" value="Salvar">
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
    $url_destino = pg . '/listar/list_menu';
    header("Location: $url_destino");
}
