<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if (!empty($id)) {

        if ($_SESSION['adms_niveis_acesso_id'] == 1 ) {
            $result_user = "SELECT u.*, s.nome as nome_sit, c.cor as nome_cor, niv_ac.nome as nome_niv_ac
            FROM adms_usuarios u
            INNER JOIN adms_sits_usuarios s ON u.adms_sits_usuario_id = s.id
            INNER JOIN adms_cors c ON s.adms_cor_id = c.id
            INNER JOIN adms_niveis_acesso niv_ac on niv_ac.id=u.adms_niveis_acesso_id
            WHERE u.id = '".$id."' LIMIT 1"; 
        } else {
            $result_user = "SELECT u.*, s.nome as nome_sit, c.cor as nome_cor, niv_ac.nome as nome_niv_ac
            FROM adms_usuarios u
            INNER JOIN adms_sits_usuarios s ON u.adms_sits_usuario_id = s.id
            INNER JOIN adms_cors c ON s.adms_cor_id = c.id
            INNER JOIN adms_niveis_acesso niv_ac on niv_ac.id=u.adms_niveis_acesso_id
            WHERE u.id = '".$id."' AND niv_ac.ordem > '".$_SESSION['ordem']."' LIMIT 1"; 
        }
        $resultado_user = mysqli_query($conn, $result_user);
        if (($resultado_user) && ($resultado_user->num_rows != 0 )) {
            $row_user = mysqli_fetch_assoc($resultado_user);
?>
        <body>
            <?php
                include 'app/adms/include/header.php';
            ?>
            <div class="d-flex">
                <?php 
                    include 'app/adms/include/menu.php';            
                ?>
                <div class="content p-1">
                    <div class="list-group-item">
                        <div class="d-flex">
                            <div class="mr-auto p-2">
                                <h2 class="display-4 titulo">Detalhes do Usuario</h2>
                            </div>
                            <div class="p-2">
                            <span class="d-none d-md-block">
                                <?php
                                    $btn_list = carregarBtn("listar/list_usuario",$conn);
                                    if ($btn_list) {
                                        ?>
                                        <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/list_usuario" ?>"> Listar</a>
                                        <?php
                                    }
                                ?>
                                <?php
                                    $btn_edit = carregarBtn("editar/edit_usuario",$conn);
                                    if ($btn_edit) {
                                        ?>
                                        <a class="btn btn-outline-warning btn-sm" href="<?= pg."/editar/edit_usuario?id=".$row_user
                                        ['id']."" ?>">Editar</a>
                                        <?php
                                    }
                                ?>  
                                <?php
                                    $btn_apagar = carregarBtn("processa/apagar_usuario
                                    u",$conn);
                                    if ($btn_apagar) {
                                        ?>
                                        <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_usuario?id=".$row_user
                                        ['id']."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
                                        <?php
                                    }
                                ?> 
                            </span>
                            <div class="dropdown d-block d-md-none">
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-user
                                u dropdown-user
                                u-right" aria-labelledby="acoesListar">
                                    <?php
                                        if ($btn_list) {
                                            ?>
                                                <a class="dropdown-item" href="<?= pg."/listar/list_usuario" ?>">Listar</a>
                                            <?
                                        }
                                    ?>
                                    <?php
                                        if ($btn_edit) {
                                            ?>
                                                <a class="dropdown-item" href="<?= pg."/editar/edit_usuario?id=".$id."" ?>">Editar</a>
                                            <?
                                        }
                                    ?>
                                    <?php
                                        if ($btn_apagar) {
                                            ?>
                                                <a class="dropdown-item" href="<?= pg."/processa/apagar_useu?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
                                            <?
                                        }
                                    ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <dl class="row">

                            <dt class="col-sm-3">Imagem</dt>
                            <dd class="col-sm-9">
                                <?php 
                                    if (!empty($row_user['imagem'])) {
                                        echo "<img src='".pg."/assets/imagens/usuario/".$row_user['id']."/".$row_user['imagem']."' width='150' height='150'>";
                                    }                                     
                                ?>
                            </dd>

                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?= $row_user['id'] ?></dd>

                            <dt class="col-sm-3">Nome</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['nome']?></dd>

                            <dt class="col-sm-3">Apelido</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['apelido']?></dd>

                            <dt class="col-sm-3">E-mail</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['email']?></dd>

                            <dt class="col-sm-3">Usuário</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['usuario']?></dd>

                            <dt class="col-sm-3">Nível de Acesso</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['nome_niv_ac']?></dd>

                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9"> 
                            <?php echo "<span class='badge badge-pill badge-".$row_user
                            ['nome_cor']."'>".$row_user
                            ['nome_sit']."</span>"; ?>
                            </dd>

                            <dt class="col-sm-3 text-truncate">Data de Cadastro</dt>
                            <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($row_user
                            ['created'])) ?></dd>

                            <dt class="col-sm-3 text-truncate">Última modificação</dt>
                            <dd class="col-sm-9">
                            <?php 
                                if(!empty($row_user
                                ['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_user
                                    ['modified']));
                                } else {
                                    echo "Ainda não teve alterações";
                                } 
                            ?>
                            </dd>

                        </dl>                        
                    </div>
                </div>
                <?php           
                    include_once 'app/adms/include/rodape_lib.php'
                ?>
            </div>
        </body>
    <?php
        }else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Usuário não encontrado!</div>";
            $url_destino = pg.'/listar/list_usuario';
            header("Location: $url_destino");
        }
    } else { 
        $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
        $url_destino = pg.'/acesso/login';
        header("Location: $url_destino");
    }

