<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//verificar a existencia do id na URL
if (!empty($id)) {
    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
        $result_edit_user = "SELECT * FROM adms_usuarios WHERE id='$id' LIMIT 1";
    } else {
        $result_edit_user = "SELECT user.* 
                FROM adms_usuarios user
                INNER JOIN adms_niveis_acessos niv_ac ON niv_ac.id=user.adms_niveis_acesso_id
                WHERE user.id='$id' AND niv_ac.ordem > '" . $_SESSION['ordem'] . "' LIMIT 1";
    }

    $resultado_edit_user = mysqli_query($conn, $result_edit_user);
    //Verificar se encontrou a página no banco de dados
    if (($resultado_edit_user) AND ( $resultado_edit_user->num_rows != 0)) {
        $row_edit_user = mysqli_fetch_assoc($resultado_edit_user);
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
                                <h2 class="display-4 titulo">Editar Usuário</h2>
                            </div>
                            <div class="p-2">
                                <span class = "d-none d-md-block">
                                    <?php
                                    $btn_list = carregarBtn('listar/list_usuario', $conn);
                                    if ($btn_list) {
                                        echo "<a href='" . pg . "/listar/list_usuario' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                    }
                                    $btn_vis = carregarBtn('visualizar/vis_usuario', $conn);
                                    if ($btn_vis) {
                                        echo "<a href='" . pg . "/visualizar/vis_usuario?id=" . $row_edit_user['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar </a> ";
                                    }
                                    $btn_apagar = carregarBtn('processa/apagar_usuario', $conn);
                                    if ($btn_apagar) {
                                        echo "<a href='" . pg . "/processa/apagar_usuario?id=" . $row_edit_user['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                    }
                                    ?>
                                </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($btn_list) {
                                            echo "<a class='dropdown-item' href='" . pg . "/listar/list_menu'>Listar</a>";
                                        }
                                        if ($btn_vis) {
                                            echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_menu?id=" . $row_edit_user['id'] . "'>Visualizar</a>";
                                        }
                                        if ($btn_apagar) {
                                            echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_menu?id=" . $row_edit_user['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div><hr>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_usuario" enctype="multipart/form-data">  
                            <input type="hidden" name="id" value="<?php
                            if (isset($row_edit_user['id'])) {
                                echo $row_edit_user['id'];
                            }
                            ?>">

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
                                            } elseif (!isset($_SESSION['dados']['adms_niveis_acesso_id']) AND ( isset($row_edit_user['adms_niveis_acesso_id']) AND ( $row_edit_user['adms_niveis_acesso_id'] == $row_niv_ac['id']))) {
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
                                            } elseif (!isset($_SESSION['dados']['adms_sits_usuario_id']) AND ( isset($row_edit_user['adms_sits_usuario_id']) AND ( $row_edit_user['adms_sits_usuario_id'] == $row_sit_user['id']))) {
                                                echo "<option value='" . $row_sit_user['id'] . "' selected>" . $row_sit_user['nome'] . "</option>";
                                            } else {
                                                echo "<option value='" . $row_sit_user['id'] . "'>" . $row_sit_user['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
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
                            <input name="SendEditUser" type="submit" class="btn btn-warning" value="Salvar">
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
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}