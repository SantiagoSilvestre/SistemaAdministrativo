<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)) {
    $result_carousel_vis = "SELECT c.*, st.nome as situacao, g.cor 
                      FROM sts_carousels c
                      INNER JOIN sts_situacoes st ON c.sts_situacoe_id = st.id
                      LEFT JOIN sts_cors g ON st.sts_cor_id = g.id
                      WHERE c.id = '".$id."' LIMIT 1";
    $resultado_carousel_vis = mysqli_query($conn, $result_carousel_vis);

    if(($resultado_carousel_vis) && ($resultado_carousel_vis->num_rows != 0)) {
        $row_carousel_vis = mysqli_fetch_assoc($resultado_carousel_vis);
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
                                    <h2 class="display-4 titulo">Detalhes do Carousel STS </h2>
                                </div>
                                <div class="p-2">
                                <span class="d-none d-md-block">
                                    <?php
                                        $btn_list = carregarBtn("listar/sts_list_carousels",$conn);
                                        if ($btn_list) {
                                            ?>
                                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_carousels" ?>"> Listar</a>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                        $btn_edit = carregarBtn("editar/sts_edit_carousel",$conn);
                                        if ($btn_edit) {
                                            ?>
                                            <a class="btn btn-outline-warning btn-sm" href="<?= pg."/editar/sts_edit_carousel?id=".$id."" ?>">Editar</a>
                                            <?php
                                        }
                                    ?>  
                                    <?php
                                        $btn_apagar = carregarBtn("processa/apagar_carousel_sts",$conn);
                                        if ($btn_apagar) {
                                            ?>
                                            <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_carousel_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                                    <a class="dropdown-item" href="<?= pg."/listar/sts_list_carousels" ?>">Listar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_edit) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/editar/sts_edit_carousel?id=".$id."" ?>">Editar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_apagar) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/processa/apagar_carousel_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                <dd class="col-sm-9"><?= $row_carousel_vis['id'] ?></dd>

                                <dt class="col-sm-3">Nome</dt>
                                <dd class="col-sm-9"><?= $row_carousel_vis['nome'] ?></dd>

                                <dt class="col-sm-3">Imagem</dt>
                                <dd class="col-sm-9">
                                <img src="<?php echo pgsite.'/assets/imagens/carousel/'.$row_carousel_vis['id'].'/'.$row_carousel_vis['imagem'];?>" id="preview-user" class="img-thumbnail" style="width: 287px; heith: 150px;">
                                </dd>

                                <dt class="col-sm-3">Título</dt>
                                <dd class="col-sm-9"><?= $row_carousel_vis['titulo'] ?></dd>

                                <dt class="col-sm-3">Descrição</dt>
                                <dd class="col-sm-9"><?= $row_carousel_vis['descricao'] ?></dd>

                                <dt class="col-sm-3">Posição do texto</dt>
                                <dd class="col-sm-9"><?= $row_carousel_vis['posicao_text'] ?></dd>

                                <dt class="col-sm-3">Título do botão</dt>
                                <dd class="col-sm-9"><?= $row_carousel_vis['titulo_botao'] ?></dd>

                                <dt class="col-sm-3">Situação</dt>
                                <dd class="col-sm-9"><?= "<span class='badge badge-".$row_carousel_vis['cor']."'>".$row_carousel_vis['situacao']."</span>" ; ?></dd>

                                <dt class="col-sm-3 text-truncate">Data de Criação</dt>
                                <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($row_carousel_vis['created'])) ?></dd>

                                <dt class="col-sm-3 text-truncate">Última modificação</dt>
                                <dd class="col-sm-9">
                                <?php 
                                    if(!empty($row_carousel_vis['modified'])) {
                                        echo date('d/m/Y H:i:s', strtotime($row_carousel_vis['modified']));
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
        $url_destino = pg.'/listar/sts_list_carousels';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}