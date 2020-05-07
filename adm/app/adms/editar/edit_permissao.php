<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
//verificar a existencia do id na URL
if (!empty($id)) {
    $result_edit_pg = "SELECT pg.icone, 
            nivpg.id, nivpg.adms_menu_id, nivpg.adms_niveis_acesso_id
            FROM adms_paginas pg
            INNER JOIN adms_nivacs_pgs nivpg ON nivpg.adms_paginas_id=pg.id
            WHERE nivpg.id='$id' LIMIT 1";
    $resultado_edit_pg = mysqli_query($conn, $result_edit_pg);
//Verificar se encontrou o usuário no banco de dados
    if (($resultado_pg) AND ( $resultado_pg->num_rows != 0)) {
        $row_edit_pg = mysqli_fetch_assoc($resultado_edit_pg);
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
                                <h2 class="display-4 titulo">Editar Permissão</h2>
                            </div>
                            <div class="p-2">
                                <?php
                                $btn_list = carregarBtn('listar/list_permissao', $conn);
                                if ($btn_list) {
                                    echo "<a href='" . pg . "/listar/list_permissao?id=".$row_edit_pg['adms_niveis_acesso_id']."' class='btn btn-outline-info btn-sm'>Listar</a> ";
                                }
                                ?>
                            </div>
                        </div><hr>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <form method="POST" action="<?php echo pg; ?>/processa/proc_edit_permissao">  
                            <input type="hidden" name="id" value="<?php echo $row_edit_pg['id']; ?>">
                            
                            <div class="form-row">                                
                                <div class="form-group col-md-6">
                                    <label>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Página de icone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>. Somente inserir o nome, Ex: fas fa-volume-up">
                                            <i class="fas fa-question-circle"></i>
                                        </span> Ícone
                                    </label>
                                    <input name="icone" type="text" class="form-control" placeholder="Ícone da página" value="<?php
                                    if (isset($_SESSION['dados']['icone'])) {
                                        echo $_SESSION['dados']['icone'];
                                    } elseif (isset($row_edit_pg['icone'])) {
                                        echo $row_edit_pg['icone'];
                                    }
                                    ?>">
                                </div>
                                <div class="form-group col-md-6">
                                    <?php
                                    $result_menus = "SELECT * FROM adms_menu";
                                    $resultado_menus = mysqli_query($conn, $result_menus);
                                    ?>
                                    <label>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Selecionar para qual item de menu pertence a página.">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                        <span class="text-danger">*</span> Item de Menu
                                    </label>
                                    <select name="adms_menu_id" id="adms_menu_id" class="form-control">
                                        <option value="">Selecione</option>
                                        <?php
                                        while ($row_menus = mysqli_fetch_array($resultado_menus)) {
                                            if (isset($_SESSION['dados']['adms_menu_id']) AND ( $_SESSION['dados']['adms_menu_id'] == $row_menus['id'])) {
                                                echo "<option value='" . $row_menus['id'] . "' selected>" . $row_menus['nome'] . "</option>";
                                            }
                                            //Preencher com informações do banco de dados caso não tenha nenhum valor salvo na sessão $_SESSION['dados']
                                            elseif (!isset($_SESSION['dados']['adms_menu_id']) AND isset($row_edit_pg['adms_menu_id']) AND ( $row_edit_pg['adms_menu_id'] == $row_menus['id'])) {
                                                echo "<option value='" . $row_menus['id'] . "' selected>" . $row_menus['nome'] . "</option>";
                                            } else {
                                                echo "<option value='" . $row_menus['id'] . "'>" . $row_menus['nome'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>                                
                            </div>
                            
                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendEditPer" type="submit" class="btn btn-warning" value="Salvar">
                        </form>
                    </div>    
                </div>
                <?php
                unset($_SESSION['dados']);
                include_once 'app/adms/include/rodape_lib.php';
                ?>

            </div>
        </body>
        <?php
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
        $url_destino = pg . '/listar/list_pagina';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}