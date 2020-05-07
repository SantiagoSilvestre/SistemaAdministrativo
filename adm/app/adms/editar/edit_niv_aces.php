<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if($id) {
        if($_SESSION['adms_niveis_acesso_id'] == 1 ){
            $result_niv_aces_ed = "SELECT * FROM adms_niveis_acesso WHERE id = $id LIMIT 1";
        }else {
            $result_niv_aces_ed = "SELECT * FROM adms_niveis_acesso WHERE ordem > '".$_SESSION['ordem']."' AND id = $id LIMIT 1";
        }
        
        $resultado_niv_aces_ed = mysqli_query($conn, $result_niv_aces_ed);
        if(($resultado_niv_aces_ed) && ($resultado_niv_aces_ed->num_rows != 0)) {
            $row_nivac_ed = mysqli_fetch_assoc($resultado_niv_aces_ed);
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
                        <h2 class="display-4 titulo">Editar Nível de Acesso</h2>
                    </div>
                    <div class="p-2">
                    <span class="d-none d-md-block">
                        <?php
                            $btn_list = carregarBtn("visualizar/vis_niv_aces",$conn);
                            if ($btn_list) {
                                ?>
                                <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/list_niv_aces" ?>"> Listar</a>
                                <?php
                            }
                        ?>
                        <?php
                            $btn_vis = carregarBtn("visualizar/vis_niv_aces",$conn);
                            if ($btn_vis) {
                                ?>
                                <a class="btn btn-outline-primary btn-sm" href="<?= pg."/visualizar/vis_niv_aces?id=".$id."" ?>">Visualizar</a>
                                <?php
                            }
                        ?>  
                        <?php
                            $btn_apagar = carregarBtn("processa/apagar_niv_aces",$conn);
                            if ($btn_apagar) {
                                ?>
                                <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_niv_aces?id=".$id."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                        <a class="dropdown-item" href="<?= pg."/listar/list_niv_aces" ?>">Listar</a>
                                    <?
                                }
                            ?>
                            <?php
                                if ($btn_vis) {
                                    ?>
                                        <a class="dropdown-item" href="<?= pg."/visualizar/vis_niv_aces?id=".$id."" ?>">Visualizar</a>
                                    <?
                                }
                            ?>
                            <?php
                                if ($btn_apagar) {
                                    ?>
                                        <a class="dropdown-item" href="<?= pg."/processa/apagar_niv_aces?id=".$id."" ?>"data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
                                    <?
                                }
                            ?>
                        </div>
                    </div>
                    </div>
                </div>
                <hr>
                <?php
                    if(isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <form method="POST" action="<?= pg; ?>/processa/proc_edit_niv_aces">
                    <input type="hidden" name="id" value="<?= ( isset($row_nivac_ed['id'])) ? $row_nivac_ed['id'] : ''?>">
                    <div class="form-group">
                        <span class="text-danger">* </span>
                        <label>Nome:</label>
                        <input name="nome_niv_aces" type="text" class="form-control" 
                        value="<?= ( isset($row_nivac_ed['nome'])) ? $row_nivac_ed['nome'] : ''?>" id="nome_niv_aces" placeholder="Nome do nível de acesso">
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendEditNivAc" id="SendEditNivAc"  type="submit" class="btn btn-warning" value="Salvar"></input>
                </form>
            </div>
        <?php           
            include_once 'app/adms/include/rodape_lib.php'
        ?>
    </div>
</body>
<?php
        }else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Nível de acesso não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
            $url_destino = pg.'/listar/list_niv_aces';
            header("Location: $url_destino");

        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Nível de acesso não encontrado!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
            </button></div>";
            $url_destino = pg.'/listar/list_niv_aces';
            header("Location: $url_destino");
    }
