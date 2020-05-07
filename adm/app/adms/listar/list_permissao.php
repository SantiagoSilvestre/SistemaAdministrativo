<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!empty($id)) {
    //Receber o número da página
    $pagina_atual = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_NUMBER_INT);
    $pagina = (!empty($pagina_atual) ? $pagina_atual : 1);

    //Setar a quantidade de itens por pagina
    $qnt_result_pg = 50;

    //Calcular o inicio visualização
    $inicio = ($qnt_result_pg * $pagina) - $qnt_result_pg;

    if ($_SESSION['adms_niveis_acesso_id'] == 1) {
        $result_niv_ac = "SELECT nivpg.*,
                pg.nome_paginas, pg.obs
                FROM adms_nivacs_pgs nivpg
                INNER JOIN adms_paginas pg ON pg.id=nivpg.adms_paginas_id
                WHERE nivpg.adms_niveis_acesso_id='$id' AND pg.depend_pg=0 
                ORDER BY nivpg.ordem ASC
                LIMIT $inicio, $qnt_result_pg";
    } else {
        $result_niv_ac = "SELECT nivpg.*,
                pg.nome_paginas, pg.obs
                FROM adms_nivacs_pgs nivpg
                INNER JOIN adms_paginas pg ON pg.id=nivpg.adms_paginas_id
                WHERE nivpg.adms_niveis_acesso_id='$id' 
                ORDER BY nivpg.ordem ASC
                LIMIT $inicio, $qnt_result_pg";
    }
    $resultado_niv_ac = mysqli_query($conn, $result_niv_ac);

    //verificar se encontrou alguma cadastro
    if (($resultado_niv_ac) AND ( $resultado_niv_ac->num_rows != 0)) {
        include_once 'app/adms/include/head.php';
        ?>
        <body>    
            <?php
            include_once 'app/adms/include/header.php';
            ?>
            <div class="d-flex">
                <?php
                include_once 'app/adms/include/menu.php';
                ?>
                <div class="content p-1">
                    <div class="list-group-item">
                        <div class="d-flex">
                            <div class="mr-auto p-2">
                                <?php
                                $result_nome_nivac = "SELECT nome FROM adms_niveis_acesso WHERE id='$id' LIMIT 1";
                                $resultado_nome_nivac = mysqli_query($conn, $result_nome_nivac);
                                $row_nome_nivac = mysqli_fetch_assoc($resultado_nome_nivac);
                                ?>
                                <h2 class="display-4 titulo">Listar Permissões - <?php echo $row_nome_nivac['nome']; ?></h2>
                            </div>
                            <div class="p-2">
                                <?php
                                $btn_list = carregarBtn('listar/list_niv_aces', $conn);
                                if ($btn_list) {
                                    echo "<a href='" . pg . "/listar/list_niv_aces' class='btn btn-outline-info btn-sm'>Listar</a>";
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Página</th>
                                        <th class="d-none d-sm-table-cell text-center">Permissão</th>
                                        <th class="d-none d-sm-table-cell text-center">Menu</th>
                                        <th class="d-none d-sm-table-cell text-center">Dropdown</th>
                                        <th class="d-none d-sm-table-cell text-center">Ordem</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $qnt_linhas_exe = 1;
                                    while ($row_niv_ac = mysqli_fetch_assoc($resultado_niv_ac)) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row_niv_ac['id']; ?></td>
                                            <td>
                                                <span tabindex="0" data-placement="top" data-toggle="tooltip" title="<?php echo $row_niv_ac['obs']; ?>">
                                                    <i class="fas fa-question-circle"></i>
                                                </span>
                                                <?php echo $row_niv_ac['nome_paginas']; ?>
                                            </td>
                                            <td class="d-none d-sm-table-cell text-center">
                                                <?php 
                                                $btn_lib_per = carregarBtn('processa/proc_lib_per', $conn);
                                                if($btn_lib_per){
                                                    if($row_niv_ac['permissao'] == 1){
                                                        echo "<a href='".pg."/processa/proc_lib_per?id=".$row_niv_ac['id']."'><span class='badge badge-pill badge-success'>Liberado</span></a>";
                                                    }else{
                                                        echo "<a href='".pg."/processa/proc_lib_per?id=".$row_niv_ac['id']."'><span class='badge badge-pill badge-danger'>Bloqueado</span></a>";
                                                    }
                                                }else{
                                                    if($row_niv_ac['permissao'] == 1){
                                                        echo "<span class='badge badge-pill badge-success'>Liberado</span>";
                                                    }else{
                                                        echo "<span class='badge badge-pill badge-danger'>Bloqueado</span>";
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="d-none d-sm-table-cell text-center">
                                                <?php 
                                                $btn_lib_menu = carregarBtn('processa/proc_lib_menu', $conn);
                                                if($btn_lib_menu){
                                                    if($row_niv_ac['lib_menu'] == 1){
                                                        echo "<a href='".pg."/processa/proc_lib_menu?id=".$row_niv_ac['id']."'><span class='badge badge-pill badge-success'>Liberado</span></a>";
                                                    }else{
                                                        echo "<a href='".pg."/processa/proc_lib_menu?id=".$row_niv_ac['id']."'><span class='badge badge-pill badge-danger'>Bloqueado</span></a>";
                                                    }
                                                }else{
                                                    if($row_niv_ac['lib_menu'] == 1){
                                                        echo "<span class='badge badge-pill badge-success'>Liberado</span>";
                                                    }else{
                                                        echo "<span class='badge badge-pill badge-danger'>Bloqueado</span>";
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="d-none d-sm-table-cell text-center">
                                            <?php 
                                                $btn_lib_dropdown = carregarBtn('processa/proc_lib_dropdown', $conn);
                                                if($btn_lib_dropdown){
                                                    if($row_niv_ac['dropdown'] == 1){
                                                        echo "<a href='".pg."/processa/proc_lib_dropdown?id=".$row_niv_ac['id']."'><span class='badge badge-pill badge-success'>Sim</span></a>";
                                                    }else{
                                                        echo "<a href='".pg."/processa/proc_lib_dropdown?id=".$row_niv_ac['id']."'><span class='badge badge-pill badge-danger'>Não</span></a>";
                                                    }
                                                }else{
                                                    if($row_niv_ac['dropdown'] == 1){
                                                        echo "<span class='badge badge-pill badge-success'>Sim</span>";
                                                    }else{
                                                        echo "<span class='badge badge-pill badge-danger'>Não</span>";
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="d-none d-sm-table-cell"><?php echo $row_niv_ac['ordem']; ?></td>
                                            <td>
                                                <?php
                                                    $btn_edit = carregarBtn('editar/edit_permissao', $conn);
                                                    if ($btn_edit) {
                                                        echo "<a href='" . pg . "/editar/edit_permissao?id=" . $row_niv_ac['id'] . "' class='btn btn-outline-warning btn-sm'>Editar</a> ";
                                                    }
                                                   $btn_ordem_menu = carregarBtn('processa/proc_ordem_menu', $conn); 
                                                   if ($btn_ordem_menu) {
                                                        if ($qnt_linhas_exe == 1) {
                                                            echo "<button class='btn btn-outline-secondary btn-sm disabled'><i class='fas fa-angle-double-up'></i></button> ";
                                                        } else {
                                                            echo "<a href='" . pg . "/processa/proc_ordem_menu?id=" . $row_niv_ac['id'] . "' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                                        }
                                                    }
                                                    $qnt_linhas_exe ++;
                                                ?>
                                            </td>
                                        <?php } ?>
                                </tbody>
                            </table>
                            <?php
                            $result_pg = "SELECT COUNT(id) AS num_result FROM adms_nivacs_pgs WHERE adms_niveis_acesso_id='$id'";
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
                            echo "<a class='page-link' href='" . pg . "/listar/list_permissao?id=$id&pagina=1' tabindex='-1'>Primeira</a>";
                            echo "</li>";

                            for ($pag_ant = $pagina - $max_links; $pag_ant <= $pagina - 1; $pag_ant++) {
                                if ($pag_ant >= 1) {
                                    echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_permissao?id=$id&pagina=$pag_ant'>$pag_ant</a></li>";
                                }
                            }

                            echo "<li class='page-item active'>";
                            echo "<a class='page-link' href='#'>$pagina</a>";
                            echo "</li>";

                            for ($pag_dep = $pagina + 1; $pag_dep <= $pagina + $max_links; $pag_dep++) {
                                if ($pag_dep <= $quantidade_pg) {
                                    echo "<li class='page-item'><a class='page-link' href='" . pg . "/listar/list_permissao?id=$id&pagina=$pag_dep'>$pag_dep</a></li>";
                                }
                            }

                            echo "<li class='page-item'>";
                            echo "<a class='page-link' href='" . pg . "/listar/list_permissao?id=$id&pagina=$quantidade_pg'>Última</a>";
                            echo "</li>";
                            echo "</ul>";
                            echo "</nav>";
                            ?>
                        </div>                        
                    </div>


                    <?php
                    include_once 'app/adms/include/rodape_lib.php';
                    ?>
                </div>
            </div>
        </body>
        <?php
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Permissão não encontrada!</div>";
        $url_destino = pg . '/listar/list_niv_aces';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

