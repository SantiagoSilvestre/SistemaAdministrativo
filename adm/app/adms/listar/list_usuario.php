<?php
if (!isset($seg)) {
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
                            <h2 class="display-4 titulo">Listar Usuario</h2>
                        </div>
                        <div class="p-2">
                            <?php
                            $btn_cad = carregarBtn('cadastrar/cad_usuario', $conn);
                            if ($btn_cad) {
                                echo "<a href='" . pg . "/cadastrar/cad_usuario' class='btn btn-outline-success btn-sm'>Cadastrar</a>";
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

                    //Setar a quantidade de itens por pagina
                    $qnt_result_pg = 10;
                    //Calcular o inicio visualização
                    $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

                    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
                        $resul_user = "SELECT u.*, n.nome as nome_niv_aces 
                        FROM adms_usuarios u
                        INNER JOIN adms_niveis_acesso n ON u.adms_niveis_acesso_id = n.id
                        ORDER BY u.id DESC LIMIT $inicio, $qnt_result_pg";
                    } else {
                        $resul_user = "SELECT u.*, n.nome as nome_niv_aces 
                        FROM adms_usuarios u
                        INNER JOIN adms_niveis_acesso n ON u.adms_niveis_acesso_id = n.id
                        WHERE n.ordem > '".$_SESSION['ordem']."'
                        ORDER BY u.id DESC LIMIT $inicio, $qnt_result_pg";
                    }

                    
                    $resultado_user = mysqli_query($conn, $resul_user);
                    if (($resultado_user) AND ( $resultado_user->num_rows != 0)) { 
                    ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th class="d-none d-sm-table-cell">E-mail</th>
                                        <th class="d-none d-sm-table-cell">Nível de Acesso</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                while ($row_user = mysqli_fetch_assoc($resultado_user)) {
                                    ?>
                                    <tr>
                                        <th><?php echo $row_user['id']; ?></th>
                                        <td><?php echo $row_user['nome']; ?></td>
                                        <td class="d-none d-sm-table-cell"><?php echo $row_user['email']; ?></td>
                                        <td class="d-none d-sm-table-cell"><?php echo $row_user['nome_niv_aces']; ?></td>
                                        <td class="text-center">
                                            <span class="d-none d-md-block">
                                                <?php

                                                $btn_vis = carregarBtn('visualizar/vis_usuario', $conn);
                                                if ($btn_vis) {
                                                    echo "<a href='" . pg . "/visualizar/vis_usuario?id=" . $row_user['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                                }
                                                $btn_edit = carregarBtn('editar/edit_usuario', $conn);
                                                if ($btn_edit) {
                                                    echo "<a href='" . pg . "/editar/edit_usuario?id=" . $row_user['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                                }
                                                $btn_apagar = carregarBtn('processa/apagar_usuario', $conn);
                                                if ($btn_apagar) {
                                                    echo "<a href='" . pg . "/processa/apagar_usuario?id=" . $row_user['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_usuario?id=" . $row_user['id'] . "'>Visualizar</a>";
                                                    }
                                                    if ($btn_edit) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/editar/edit_usuario?id=" . $row_user['id'] . "'>Editar</a>";
                                                    }
                                                    if ($btn_apagar) {
                                                        echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_usuario?id=" . $row_user['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
                                $result_pg = "SELECT COUNT(id) AS num_result FROM adms_usuarios";
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
                                echo "<a class='page-link' href='" . pg . "/listar/list_usuario?pagina=1' tabindex='-1'>Primeira</a>";
                                echo "</li>";

                                for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                                    if ($pag_ant >= 1) {
                                        echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_usuario?pagina=$pag_ant'>$pag_ant</a></li>";
                                    }
                                }

                                echo "<li class='page-item active'>";
                                echo "<a class='page-link' href='#'>$pagina</a>";
                                echo "</li>";

                                for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                                    if ($pag_dep <= $quantidade_pg) {
                                        echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_usuario?pagina=$pag_dep'>$pag_dep</a></li>";
                                    }
                                }

                                echo "<li class='page-item'>";
                                echo "<a class='page-link' href='" . pg . "/listar/list_usuario?pagina=$quantidade_pg'>Última</a>";
                                echo "</li>";
                                echo "</ul>";
                                echo "</nav>";
                            ?>
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
