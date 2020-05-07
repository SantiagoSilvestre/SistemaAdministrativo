<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)) {
    $result_faq_vis = "SELECT pg.*, st.nome as situacao, g.cor 
                      FROM sts_pergs_resps pg
                      INNER JOIN sts_situacoes st ON pg.sts_situacoe_id = st.id
                      LEFT JOIN sts_cors g ON st.sts_cor_id = g.id
                      WHERE pg.id = '".$id."' LIMIT 1";
    $resultado_faq_vis = mysqli_query($conn, $result_faq_vis);

    if(($resultado_faq_vis) && ($resultado_faq_vis->num_rows != 0)) {
        $row_faq_vis = mysqli_fetch_assoc($resultado_faq_vis);
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
                                    <h2 class="display-4 titulo">Detalhes do FAQ STS </h2>
                                </div>
                                <div class="p-2">
                                <span class="d-none d-md-block">
                                    <?php
                                        $btn_list = carregarBtn("listar/sts_list_perg_resp",$conn);
                                        if ($btn_list) {
                                            ?>
                                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_perg_resp" ?>"> Listar</a>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                        $btn_edit = carregarBtn("editar/sts_edit_per_resp",$conn);
                                        if ($btn_edit) {
                                            ?>
                                            <a class="btn btn-outline-warning btn-sm" href="<?= pg."/editar/sts_edit_per_resp?id=".$id."" ?>">Editar</a>
                                            <?php
                                        }
                                    ?>  
                                    <?php
                                        $btn_apagar = carregarBtn("processa/apagar_per_resp_sts",$conn);
                                        if ($btn_apagar) {
                                            ?>
                                            <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_per_resp_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                                    <a class="dropdown-item" href="<?= pg."/listar/sts_list_perg_resp" ?>">Listar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_edit) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/editar/sts_edit_per_resp?id=".$id."" ?>">Editar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_apagar) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/processa/apagar_per_resp_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                <dd class="col-sm-9"><?= $row_faq_vis['id'] ?></dd>

                                <dt class="col-sm-3">Pergutna</dt>
                                <dd class="col-sm-9"><?= $row_faq_vis['pergunta'] ?></dd>

                                <dt class="col-sm-3">Resposta</dt>
                                <dd class="col-sm-9"><?= $row_faq_vis['resposta'] ?></dd>
                                
                                <dt class="col-sm-3">Situação</dt>
                                <dd class="col-sm-9"><?= "<span class='badge badge-".$row_faq_vis['cor']."'>".$row_faq_vis['situacao']."</span>" ; ?></dd>

                                <dt class="col-sm-3 text-truncate">Data de Criação</dt>
                                <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($row_faq_vis['created'])) ?></dd>

                                <dt class="col-sm-3 text-truncate">Última modificação</dt>
                                <dd class="col-sm-9">
                                <?php 
                                    if(!empty($row_faq_vis['modified'])) {
                                        echo date('d/m/Y H:i:s', strtotime($row_faq_vis['modified']));
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
        $url_destino = pg.'/listar/sts_list_perg_resp';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}