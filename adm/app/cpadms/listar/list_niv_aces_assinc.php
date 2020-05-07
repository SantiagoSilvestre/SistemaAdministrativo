<?php
session_start();
$seg = true;
//sleep(5);
require '../../../config/conexao.php';
require '../../../config/config.php';

$pagina = filter_input(INPUT_POST, "pagina", FILTER_SANITIZE_NUMBER_INT);
$qnt_result_pg = filter_input(INPUT_POST, "qnt_result_pg", FILTER_SANITIZE_NUMBER_INT);

//validar botão
require '../../../lib/lib_permissao.php';
$btn_or_nivac = carregarBtn('processa/proc_ordem_niv_aces', $conn);
$btn_list_per = carregarBtn('listar/list_permissao', $conn);
$btn_vis = carregarBtn('visualizar/vis_niv_aces', $conn);
$btn_edit = carregarBtn('editar/edit_niv_aces', $conn);
$btn_apagar = carregarBtn('processa/apagar_niv_aces', $conn);

//Calcular o inicio visualização
$inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

if ($_SESSION['adms_niveis_acesso_id'] == 1) {
    $resul_niv_aces = "SELECT * FROM adms_niveis_acesso ORDER BY ordem ASC LIMIT $inicio, $qnt_result_pg";
} else {
    $resul_niv_aces = "SELECT * FROM adms_niveis_acesso WHERE ordem > '" . $_SESSION['ordem'] . "' ORDER BY ordem ASC LIMIT $inicio, $qnt_result_pg";
}

$resultado_niv_aces = mysqli_query($conn, $resul_niv_aces);
if (($resultado_niv_aces) AND ( $resultado_niv_aces->num_rows != 0)) {
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
                while ($row_niv_aces = mysqli_fetch_assoc($resultado_niv_aces)) {
                    ?>
                    <tr>
                        <th><?php echo $row_niv_aces['id']; ?></th>
                        <td><?php echo $row_niv_aces['nome']; ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo $row_niv_aces['ordem']; ?></td>
                        <td class="text-center">
                            <span class="d-none d-md-block">
                                <?php
                                if ($qnt_linhas_exe == 1) {
                                    if ($btn_or_nivac) {
                                        echo "<button class='btn btn-outline-secondary btn-sm disabled'><i class='fas fa-angle-double-up'></i></button> ";
                                    }
                                } else {
                                    if ($btn_or_nivac) {
                                        echo "<a href='" . pg . "/processa/proc_ordem_niv_aces?id=" . $row_niv_aces['id'] . "' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                    }
                                }
                                $qnt_linhas_exe++;

                                if ($btn_list_per) {
                                    echo "<a href='" . pg . "/listar/list_permissao?id=" . $row_niv_aces['id'] . "' class='btn btn-outline-info btn-sm'>Permissão</a> ";
                                }

                                if ($btn_vis) {
                                    echo "<a href='" . pg . "/visualizar/vis_niv_aces?id=" . $row_niv_aces['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
                                }
                                if ($btn_edit) {
                                    echo "<a href='" . pg . "/editar/edit_niv_aces?id=" . $row_niv_aces['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
                                }
                                if ($btn_apagar) {
                                    echo "<a href='" . pg . "/processa/apagar_niv_aces?id=" . $row_niv_aces['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
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
                                        echo "<a class='dropdown-item' href='" . pg . "/visualizar/vis_niv_aces?id=" . $row_niv_aces['id'] . "'>Visualizar</a>";
                                    }
                                    if ($btn_edit) {
                                        echo "<a class='dropdown-item' href='" . pg . "/editar/edit_niv_aces?id=" . $row_niv_aces['id'] . "'>Editar</a>";
                                    }
                                    if ($btn_apagar) {
                                        echo "<a class='dropdown-item' href='" . pg . "/processa/apagar_niv_aces?id=" . $row_niv_aces['id'] . "' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
        $result_pg = "SELECT COUNT(id) AS num_result FROM adms_niveis_acesso WHERE ordem >= '" . $_SESSION['ordem'] . "'";
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
        echo '<a class="page-link" href="#" onclick="listar_usuario( 1,'.$qnt_result_pg.')" tabindex="-1">Primeira</a>';
        echo "</li>";

        for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
            if ($pag_ant >= 1) {
                echo '<li class="page-item"><a class="page-link" onclick="listar_usuario( '.$pag_ant.' ,'.$qnt_result_pg.')" href="#">'.$pag_ant.'</a></li>';
            }
        }

        echo "<li class='page-item active'>";
        echo "<a class='page-link' href='#'>$pagina</a>";
        echo "</li>";

        for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
            if ($pag_dep <= $quantidade_pg) {
                echo '<li class="page-item"><a class="page-link" onclick="listar_usuario( '.$pag_dep.' ,'.$qnt_result_pg.')" href="#">'.$pag_dep.'</a></li>';
            }
        }

        echo "<li class='page-item'>";
        echo '<a class="page-link" href="#" onclick="listar_usuario( '.$quantidade_pg.','.$qnt_result_pg.')">Última</a>';
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