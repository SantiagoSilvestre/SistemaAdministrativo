<?php 
    if(!isset($seg)){
        exit;
    }
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
                        <h2 class="display-4 titulo">Listar Menu</h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_cad = carregarBtn('cadastrar/cad_menu', $conn);
                        if ($btn_cad) {
                            echo "<a href='" . pg . "/cadastrar/cad_menu' class='btn btn-outline-success btn-sm'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>

                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }

                //Receber o número da página
                $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
                $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;

                $qnt_result_pg = 10 ;

                $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

                $result_menu = "SELECT * FROM adms_menu ORDER BY ordem ASC LIMIT $inicio, $qnt_result_pg";
                $resultado_menu = mysqli_query($conn, $result_menu);

                if (($resultado_menu) && ($resultado_menu->num_rows != 0)) {
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th class="d-none d-sm-table-cell">Ordem</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $qnt_linhas_exe = 1;
                                while ($row_menu = mysqli_fetch_assoc($resultado_menu)) {
                                    ?>
                                    <tr>
                                        <th><?php echo $row_menu['id']; ?></th>
                                        <td><?php 
                                                if ($row_menu['icone']) {
                                                    echo "<i class='".$row_menu['icone']."'></i>  ";
                                                }
                                                echo $row_menu['nome']; 
                                            ?></td>
                                        <td class="d-none d-sm-table-cell"><?php echo $row_menu['ordem']; ?></td>
                                        
                                        <td class="text-center">
                                            <span class="d-none d-md-block">
                                                <?php
                                                $btn_or_nivac = carregarBtn('processa/proc_ordem_men', $conn);
                                                if ($qnt_linhas_exe == 1) {
                                                    if ($btn_or_nivac) {
                                                        echo "<button class='btn btn-outline-secondary btn-sm disabled'><i class='fas fa-angle-double-up'></i></button> ";
                                                    }
                                                } else {
                                                    if ($btn_or_nivac) {
                                                        echo "<a href='" . pg . "/processa/proc_ordem_men?id=" . $row_menu['id'] . "' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                                    }
                                                }
                                                $qnt_linhas_exe++;

                                                $btn_vis = carregarBtn('visualizar/vis_menu', $conn);
                                                if ($btn_vis) {
                                                    echo "<a href='" . pg . "/visualizar/vis_menu?id=" . $row_menu['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                                }
                                                $btn_edit = carregarBtn('editar/edit_menu', $conn);
                                                if ($btn_edit) {
                                                    echo "<a href='" . pg . "/editar/edit_menu?id=" . $row_menu['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                                }
                                                $btn_apagar = carregarBtn('processa/apagar_menu', $conn);
                                                if ($btn_apagar) {
                                                    echo "<a href='" . pg . "/processa/apagar_menu?id=" . $row_menu['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
                                                }
                                                ?>
                                            </span>
                                            <div class="dropdown d-block d-md-none">
                                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Ações
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                                    <?php
                                                    if ($btn_vis) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_menu?id=" . $row_menu['id'] . "'>Visualizar</a>";
                                                    }
                                                    if ($btn_edit) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/editar/edit_menu?id=" . $row_menu['id'] . "'>Editar</a>";
                                                    }
                                                    if ($btn_apagar) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_menu?id=" . $row_menu['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    <?php
                    $result_pg = "SELECT COUNT(id) AS num_result FROM adms_menu ";
                    $resultado_pg = mysqli_query($conn, $result_pg);
                    $row_pg = mysqli_fetch_assoc($resultado_pg);
                    //echo $row_pg['num_result'];
                    //Quantidade de pagina 
                    $quantidade_pg = ceil($row_pg['num_result'] / $qnt_result_pg);
                    //Limitar os link antes depois
                    $max_links = 2;
                    echo "<nav aria-label='paginacao-blog'>";
                    echo "<ul class='pagination pagination-sm justify-content-center'>";
                    echo "<li class='page-item'>";
                    echo "<a class='page-link' href='" . pg . "/listar/list_menu?pagina=1' tabindex='-1'>Primeira</a>";
                    echo "</li>";

                    for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                        if ($pag_ant >= 1) {
                            echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_menu?pagina=$pag_ant'>$pag_ant</a></li>";
                        }
                    }

                    echo "<li class='page-item active'>";
                    echo "<a class='page-link' href='#'>$pagina</a>";
                    echo "</li>";

                    for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                        if ($pag_dep <= $quantidade_pg) {
                            echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_menu?pagina=$pag_dep'>$pag_dep</a></li>";
                        }
                    }

                    echo "<li class='page-item'>";
                    echo "<a class='page-link' href='" . pg . "/listar/list_menu?pagina=$quantidade_pg'>Última</a>";
                    echo "</li>";
                    echo "</ul>";
                    echo "</nav>";
                    ?>                        
                </div>
                <?php
                } else {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        Nenhum registro encontrado!
                    </div>
                    <?php
                }

                ?>
            </div>
        </div>
            <?php
            include_once 'app/adms/include/rodape_lib.php'
        ?>
    </div>
</body>
