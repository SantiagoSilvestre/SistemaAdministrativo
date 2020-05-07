<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)) {
    $result_pg_vis = "SELECT p.*, tp.tipo as tipo, tp.nome as nome_tipo, st.nome as situacao, g.cor, r.nome as indexado  
                      FROM sts_paginas p
                      LEFT JOIN sts_cors g ON p.sts_situacaos_pg_id = g.id
                      LEFT JOIN sts_tps_pgs tp ON p.sts_tps_pgs_id = tp.id
                      INNER JOIN sts_situacaos_pgs st ON p.sts_situacaos_pg_id = st.id
                      LEFT JOIN sts_robots r ON p.sts_robot_id = r.id
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
                                    <h2 class="display-4 titulo">Detalhes da página STS </h2>
                                </div>
                                <div class="p-2">
                                <span class="d-none d-md-block">
                                    <?php
                                        $btn_list = carregarBtn("listar/sts_list_pagina",$conn);
                                        if ($btn_list) {
                                            ?>
                                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_pagina" ?>"> Listar</a>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                        $btn_edit = carregarBtn("editar/sts_edit_pagina",$conn);
                                        if ($btn_edit) {
                                            ?>
                                            <a class="btn btn-outline-warning btn-sm" href="<?= pg."/editar/sts_edit_pagina?id=".$id."" ?>">Editar</a>
                                            <?php
                                        }
                                    ?>  
                                    <?php
                                        $btn_apagar = carregarBtn("processa/apagar_pagina_sts",$conn);
                                        if ($btn_apagar) {
                                            ?>
                                            <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_pagina_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                                    <a class="dropdown-item" href="<?= pg."/listar/sts_list_pagina" ?>">Listar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_edit) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/editar/sts_edit_pagina?id=".$id."" ?>">Editar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_apagar) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/processa/apagar_pagina_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                <dd class="col-sm-9"><?= $row_pg_vis['nome_pagina'] ?></dd>

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
                                <dd class="col-sm-9"><?= $row_pg_vis['lib_bloq'] == 1 ? "<span class='badge badge-success'>SIM</span>" : "<span class='badge badge-danger'>Não</span>"  ?></dd>

                                <dt class="col-sm-3">Icone</dt>
                                <dd class="col-sm-9"><?= empty($row_pg_vis['icone']) ? "Vazio" : "<i class='".$row_pg_vis['icone']."'></i> :" .$row_pg_vis['icone'] ?></dd>

                                <dt class="col-sm-3">Página dependente</dt>
                                <?php 
                                    $pagina_dp = "SELECT id, nome_pagina FROM sts_paginas WHERE id ='".$row_pg_vis['depend_pg']."' ";
                                    $pg_dp = mysqli_query($conn, $pagina_dp);
                                    $row_pg_dp = mysqli_fetch_assoc($pg_dp);
                                ?>
                                <dd class="col-sm-9"><?php 
                                if ($row_pg_vis['depend_pg'] == 0) {
                                 echo "<span class='badge badge-danger'>Não</span>" ;
                                } else {
                                    ?>
                                        <a href="<?= pg."/visualizar/vis_sts_pagina?id=".$row_pg_dp['id']."" ?>"><?= $row_pg_dp['nome_pagina'] ?></a> </dd>
                                    <?php
                                }
                                 ?>

                                <dt class="col-sm-3">Tipo de Página</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['tipo'] ." - ". $row_pg_vis['nome_tipo'] ?></dd>
                                
                                <dt class="col-sm-3">Indexada</dt>
                                <dd class="col-sm-9"><?= $row_pg_vis['indexado'] ?></dd>

                                <dt class="col-sm-3">Situação</dt>
                                <dd class="col-sm-9"><?= "<span class='badge badge-".$row_pg_vis['cor']."'>".$row_pg_vis['situacao']."</span>" ; ?></dd>

                                <dt class="col-sm-3 text-truncate">Data de Criação</dt>
                                <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($row_pg_vis['created'])) ?></dd>

                                <dt class="col-sm-3 text-truncate">Última modificação</dt>
                                <dd class="col-sm-9">
                                <?php 
                                    if(!empty($row_pg_vis['modified'])) {
                                        echo date('d/m/Y H:i:s', strtotime($row_pg_vis['modified']));
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
        $url_destino = pg.'/listar/sts_list_pagina';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}