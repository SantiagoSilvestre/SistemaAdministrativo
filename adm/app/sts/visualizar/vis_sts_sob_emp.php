<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!empty($id)) {
    $result_sobemp_vis = "SELECT c.*, st.nome as situacao, g.cor 
                      FROM sts_sobs_emps c
                      INNER JOIN sts_situacoes st ON c.sts_situacoe_id = st.id
                      LEFT JOIN sts_cors g ON st.sts_cor_id = g.id
                      WHERE c.id = '".$id."' LIMIT 1";
    $resultado_sobemp_vis = mysqli_query($conn, $result_sobemp_vis);

    if(($resultado_sobemp_vis) && ($resultado_sobemp_vis->num_rows != 0)) {
        $row_sobemp_vis = mysqli_fetch_assoc($resultado_sobemp_vis);
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
                                    <h2 class="display-4 titulo">Detalhes da Sobre Empresa STS </h2>
                                </div>
                                <div class="p-2">
                                <span class="d-none d-md-block">
                                    <?php
                                        $btn_list = carregarBtn("listar/sts_list_sob_emp",$conn);
                                        if ($btn_list) {
                                            ?>
                                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_sob_emp" ?>"> Listar</a>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                        $btn_edit = carregarBtn("editar/sts_edit_sob_emp",$conn);
                                        if ($btn_edit) {
                                            ?>
                                            <a class="btn btn-outline-warning btn-sm" href="<?= pg."/editar/sts_edit_sob_emp?id=".$id."" ?>">Editar</a>
                                            <?php
                                        }
                                    ?>  
                                    <?php
                                        $btn_apagar = carregarBtn("processa/apagar_sob_emp_sts",$conn);
                                        if ($btn_apagar) {
                                            ?>
                                            <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_sob_emp_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                                    <a class="dropdown-item" href="<?= pg."/listar/sts_list_sob_emp" ?>">Listar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_edit) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/editar/sts_edit_sob_emp?id=".$id."" ?>">Editar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_apagar) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/processa/apagar_sob_emp_sts?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                <dd class="col-sm-9"><?= $row_sobemp_vis['id'] ?></dd>

                                <dt class="col-sm-3">Titulo</dt>
                                <dd class="col-sm-9"><?= $row_sobemp_vis['titulo'] ?></dd>

                                <dt class="col-sm-3">Imagem</dt>
                                <dd class="col-sm-9">
                                <img src="<?php echo pgsite.'/assets/imagens/sob_emp/'.$row_sobemp_vis['id'].'/'.$row_sobemp_vis['imagem'];?>" id="preview-user" class="img-thumbnail" style="width: 287px; heith: 150px;">
                                </dd>

                                <dt class="col-sm-3">Descricao</dt>
                                <dd class="col-sm-9"><?= $row_sobemp_vis['descricao'] ?></dd>

                                <dt class="col-sm-3">Ordem</dt>
                                <dd class="col-sm-9"><?= $row_sobemp_vis['ordem'] ?></dd>
                                
                                <dt class="col-sm-3">Situação</dt>
                                <dd class="col-sm-9"><?= "<span class='badge badge-".$row_sobemp_vis['cor']."'>".$row_sobemp_vis['situacao']."</span>" ; ?></dd>

                                <dt class="col-sm-3 text-truncate">Data de Criação</dt>
                                <dd class="col-sm-9"><?= date('d/m/Y H:i:s', strtotime($row_sobemp_vis['created'])) ?></dd>

                                <dt class="col-sm-3 text-truncate">Última modificação</dt>
                                <dd class="col-sm-9">
                                <?php 
                                    if(!empty($row_sobemp_vis['modified'])) {
                                        echo date('d/m/Y H:i:s', strtotime($row_sobemp_vis['modified']));
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
        $url_destino = pg.'/listar/sts_list_sob_emp';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}