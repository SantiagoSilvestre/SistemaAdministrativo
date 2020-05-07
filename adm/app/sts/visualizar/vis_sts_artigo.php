<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)) {
    $resul = "SELECT a.*,
                sc.nome as nome_situacao, cor.cor, cat.nome as nome_cat,
                r.nome as nome_robot, u.nome as nome_user, tpa.nome as nome_tip
                FROM sts_artigos a
                LEFT JOIN sts_situacoes sc ON a.sts_situacoe_id = sc.id
                LEFT JOIN sts_cors cor ON sc.sts_cor_id = cor.id
                LEFT JOIN sts_cats_artigos cat ON a.sts_cats_artigo_id = cat.id
                LEFT JOIN sts_robots r ON a.sts_robot_id = r.id
                LEFT JOIN adms_usuarios u ON a.adms_usuario_id = u.id
                LEFT JOIN sts_tps_artigos tpa ON a.sts_tps_artigo_id = tpa.id
                WHERE a.id = '".$id."' LIMIT 1";
    $resultado_artigo = mysqli_query($conn, $resul);

    if(($resultado_artigo) && ($resultado_artigo->num_rows != 0)) {
        $row_artigo = mysqli_fetch_assoc($resultado_artigo);
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
                                    <h2 class="display-4 titulo">Detalhes do Artigo STS </h2>
                                </div>
                                <div class="p-2">
                                <span class="d-none d-md-block">
                                    <?php
                                        $btn_list = carregarBtn("listar/sts_list_artigos",$conn);
                                        if ($btn_list) {
                                            ?>
                                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_artigos" ?>"> Listar</a>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                        $btn_edit = carregarBtn("editar/sts_edit_artigo",$conn);
                                        if ($btn_edit) {
                                            ?>
                                            <a class="btn btn-outline-warning btn-sm" href="<?= pg."/editar/sts_edit_artigo?id=".$id."" ?>">Editar</a>
                                            <?php
                                        }
                                    ?>  
                                    <?php
                                        $btn_apagar = carregarBtn("processa/apagar_artigo_sts",$conn);
                                        if ($btn_apagar) {
                                            ?>
                                            <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_artigo_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                                    <a class="dropdown-item" href="<?= pg."/listar/sts_list_artigos" ?>">Listar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_edit) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/editar/sts_edit_artigo?id=".$id."" ?>">Editar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_apagar) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/processa/apagar_artigo_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                <dd class="col-sm-9"><?= $row_artigo['id'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Título</dt>
                                <dd class="col-sm-9"><?= $row_artigo['titulo'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Autor</dt>
                                <dd class="col-sm-9"><?= $row_artigo['author'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Usuário</dt>
                                <dd class="col-sm-9"><?= $row_artigo['nome_user'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Categoria</dt>
                                <dd class="col-sm-9"><?= $row_artigo['nome_cat'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Tipo de Artigo</dt>
                                <dd class="col-sm-9"><?= $row_artigo['nome_tip'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Descrição</dt>
                                <dd class="col-sm-9"><?= $row_artigo['descricao'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Conteúdo</dt>
                                <dd class="col-sm-9"><?= $row_artigo['conteudo'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Imagem</dt>
                                <dd class="col-sm-9">
                                <img src="<?php echo pgsite.'/assets/imagens/artigo/'.$row_artigo['id'].'/'.$row_artigo['imagem'];?>" id="preview-user" class="img-thumbnail" style="width: 287px; heith: 150px;">
                                </dd>
                                <hr>

                                <dt class="col-sm-3">Slug</dt>
                                <dd class="col-sm-9"><?= $row_artigo['slug'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Palavras Chaves</dt>
                                <dd class="col-sm-9"><?= $row_artigo['keywords'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Indexada</dt>
                                <dd class="col-sm-9"><?= $row_artigo['nome_robot'] ?></dd>
                                <hr>

                                <dt class="col-sm-3">Situação</dt>
                                <dd class="col-sm-9"><?= "<span class='badge badge-".$row_artigo['cor']."'>".$row_artigo['nome_situacao']."</span>" ; ?></dd>
                                <hr>

                                <dt class="col-sm-3 text-truncate">Data de Criação</dt>
                                <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($row_artigo['created'])) ?></dd>
                                <hr>

                                <dt class="col-sm-3 text-truncate">Última modificação</dt>
                                <dd class="col-sm-9">
                                <?php 
                                    if(!empty($row_artigo['modified'])) {
                                        echo date('d/m/Y H:i:s', strtotime($row_artigo['modified']));
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
        $url_destino = pg.'/listar/sts_list_artigos';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}