<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if (!empty($id)) {

        $result_men = "SELECT m.*, s.nome as nome_sit, c.cor as nome_cor
            FROM adms_menu m
            INNER JOIN adms_sits s ON m.adms_sit_id = s.id
            INNER JOIN adms_cors c ON s.cor = c.id
            WHERE m.id = '".$id."'
            ORDER BY m.ordem ASC LIMIT 1"; 
        $resultado_men = mysqli_query($conn, $result_men);
        
        if (($resultado_men) && ($resultado_men->num_rows != 0 )) {
            $row_men = mysqli_fetch_assoc($resultado_men);
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
                                <h2 class="display-4 titulo">Detalhes do Menu</h2>
                            </div>
                            <div class="p-2">
                            <span class="d-none d-md-block">
                                <?php
                                    $btn_list = carregarBtn("listar/list_menu",$conn);
                                    if ($btn_list) {
                                        ?>
                                        <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/list_menu" ?>"> Listar</a>
                                        <?php
                                    }
                                ?>
                                <?php
                                    $btn_edit = carregarBtn("editar/edit_menu",$conn);
                                    if ($btn_edit) {
                                        ?>
                                        <a class="btn btn-outline-warning btn-sm" href="<?= pg."/editar/edit_menu?id=".$row_men['id']."" ?>">Editar</a>
                                        <?php
                                    }
                                ?>  
                                <?php
                                    $btn_apagar = carregarBtn("processa/apagar_menu",$conn);
                                    if ($btn_apagar) {
                                        ?>
                                        <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_menu?id=".$row_men['id']."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
                                        <?php
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
                                            ?>
                                                <a class="dropdown-item" href="<?= pg."/listar/list_menu" ?>">Listar</a>
                                            <?
                                        }
                                    ?>
                                    <?php
                                        if ($btn_edit) {
                                            ?>
                                                <a class="dropdown-item" href="<?= pg."/editar/edit_menu?id=".$id."" ?>">Editar</a>
                                            <?
                                        }
                                    ?>
                                    <?php
                                        if ($btn_apagar) {
                                            ?>
                                                <a class="dropdown-item" href="<?= pg."/processa/apagar_menu?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
                                            <?
                                        }
                                    ?>
                                </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <dl class="row">
                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?= $row_men['id'] ?></dd>

                            <dt class="col-sm-3">Nome</dt>
                            <dd class="col-sm-9">
                                <?php                         
                                    echo $row_men['nome'] 
                                ?></dd>
                            <dt class="col-sm-3">ìcone</dt>
                            <dd class="col-sm-9">
                                <?php
                                    echo "<i class='".$row_men['icone']."'></i>:  ";                             
                                    echo $row_men['nome'] 
                                ?></dd>

                            <dt class="col-sm-3">Ordem</dt>
                            <dd class="col-sm-9"><?= $row_men['ordem'] ?></dd>

                            <dt class="col-sm-3">Situação</dt>
                            <dd class="col-sm-9"> 
                            <?php echo "<span class='badge badge-pill badge-".$row_men['nome_cor']."'>".$row_men['nome_sit']."</span>"; ?>
                            </dd>

                            <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                            <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($row_men['created'])) ?></dd>

                            <dt class="col-sm-3 text-truncate">Última modificação</dt>
                            <dd class="col-sm-9">
                            <?php 
                                if(!empty($row_men['modified'])) {
                                    echo date('d/m/Y H:i:s', strtotime($row_men['modified']));
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
            $_SESSION['msg'] = "<div class='alert alert-danger'> Nenhum registro encontrado!</div>";
            $url_destino = pg.'/listar/list_menu';
            header("Location: $url_destino");
        }
    } else { 
        $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
        $url_destino = pg.'/acesso/login';
        header("Location: $url_destino");
    }

