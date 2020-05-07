<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)) {
    $result_pg_vis = "SELECT p.*, g.nome as nome_grupo, tp.tipo as tipo, tp.nome as nome_tipo, st.nome as situacao, st.cor, r.nome as indexado  
                      FROM adms_paginas p
                      LEFT JOIN adms_grp_pgs g ON p.adms_grps_pg_id = g.id
                      LEFT JOIN adms_tps_pg tp ON p.adms_tps_pg_id = tp.id
                      INNER JOIN adms_sits_pg st ON p.adms_sits_pg_id = st.id
                      LEFT JOIN adms_robot r ON p.adms_robot_id = r.id
                      WHERE p.id = '".$id."' LIMIT 1";
    
    
    $resultado_pg_vis = mysqli_query($conn, $result_pg_vis);

    if(($resultado_pg_vis) && ($resultado_pg_vis->num_rows != 0)) {
        $row_pg_vis = mysqli_fetch_assoc($resultado_pg_vis);
        include_once 'app/adms/include/head.php';
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
                                    <h2 class="display-4 titulo">Detalhes da página</h2>
                                </div>
                                <div class="p-2">
                                <span class="d-none d-md-block">
                                    <?php
                                        $btn_list = carregarBtn("visualizar/vis_niv_aces",$conn);
                                        if ($btn_list) {
                                            ?>
                                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/list_pagina" ?>"> Listar</a>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                        $btn_edit = carregarBtn("editar/edit_pagina",$conn);
                                        if ($btn_edit) {
                                            ?>
                                            <a class="btn btn-outline-warning btn-sm" href="<?= pg."/editar/edit_pagina?id=".$id."" ?>">Editar</a>
                                            <?php
                                        }
                                    ?>  
                                    <?php
                                        $btn_apagar = carregarBtn("processa/apagar_pagina",$conn);
                                        if ($btn_apagar) {
                                            ?>
                                            <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_pagina?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                                    <a class="dropdown-item" href="<?= pg."/listar/list_pagina" ?>">Listar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_edit) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/editar/edit_pagina?id=".$id."" ?>">Editar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_apagar) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/processa/apagar_pagina?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                <dd class="col-sm-9"><?= $row_pg_vis['id'] ?></dd>

                                <dt class="col-sm-3">Nome</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['nome_paginas'] ?></dd>

                                <dt class="col-sm-3">Endereço</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['endereco'] ?></dd>

                                <dt class="col-sm-3">Observações</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['obs'] ?></dd>

                                <dt class="col-sm-3">Palavras Chave</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['keywords'] ?></dd>

                                <dt class="col-sm-3">Descricação</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['description'] ?></dd>

                                <dt class="col-sm-3">Autor</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['author'] ?></dd>

                                <dt class="col-sm-3">Liberada para o público</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['lib_pub'] == 1 ? "<span class='badge badge-success'>SIM</span>" : "<span class='badge badge-danger'>Não</span>"  ?></dd>

                                <dt class="col-sm-3">Icone</dt>
                                <dd class="col-sm-9"><?= empty($row_pg_vis['icone']) ? "Vazio" : "<i class='".$row_pg_vis['icone']."'></i> :" .$row_pg_vis['icone'] ?></dd>

                                <dt class="col-sm-3">Página dependente</dt>
                                <?php 
                                    $pagina_dp = "SELECT id, nome_paginas FROM adms_paginas WHERE id ='".$row_pg_vis['depend_pg']."' ";
                                    $pg_dp = mysqli_query($conn, $pagina_dp);
                                    $row_pg_dp = mysqli_fetch_assoc($pg_dp);
                                ?>
                                <dd class="col-sm-9"><?php 
                                if ($row_pg_vis['depend_pg'] == 0) {
                                 echo "<span class='badge badge-danger'>Não</span>" ;
                                } else {
                                    ?>
                                        <a href="<?= pg."/visualizar/vis_pagina?id=".$row_pg_dp['id']."" ?>"><?= $row_pg_dp['nome_paginas'] ?></a> </dd>
                                    <?php
                                }
                                 ?>
                                

                                <dt class="col-sm-3">Grupo</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['nome_grupo'] ?></dd>

                                <dt class="col-sm-3">Tipo de Página</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['tipo'] ." - ". $row_pg_vis['nome_tipo'] ?></dd>
                                
                                <dt class="col-sm-3">Indexada</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['indexado'] ?></dd>

                                <dt class="col-sm-3">Situação</dt>
                                <dd class="col-sm-9"><?= "<span class='badge badge-".$row_pg_vis['cor']."'>".$row_pg_vis['situacao']."</span>" ; ?></dd>

                                <dt class="col-sm-3 text-truncate">Data de Edição</dt>
                                <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($row_pg_vis['created'])) ?></dd>

                                <dt class="col-sm-3 text-truncate">Última modificação</dt>
                                <dd class="col-sm-9">
                                <?php 
                                    if(!empty($row_niv_aces['modified'])) {
                                        echo date('d/m/Y H:i:s', strtotime($row_niv_aces['modified']));
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
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
        $url_destino = pg.'/listar/list_pagina';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}