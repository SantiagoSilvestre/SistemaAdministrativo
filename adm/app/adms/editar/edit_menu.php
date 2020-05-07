<?php 
    if(!isset($seg)){
        exit;
    }
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(!empty($id)) {
        $result_men = "SELECT * FROM adms_menu WHERE id = '".$id."' LIMIT 1";
       
        $resultado_men = mysqli_query($conn, $result_men);

        if(($resultado_men) && ($resultado_men->num_rows != 0) ){
            $row_men = mysqli_fetch_assoc($resultado_men);
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
                                    <h2 class="display-4 titulo">Editar itém de menu</h2>
                                </div>
                                <div class="p-2">
                                <span class="d-none d-md-block">
                                    <?php
                                        $btn_list = carregarBtn("visualizar/vis_niv_aces",$conn);
                                        if ($btn_list) {
                                            ?>
                                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/list_menu" ?>"> Listar</a>
                                            <?php
                                        }
                                    ?>
                                    <?php
                                        $btn_vis = carregarBtn("visualizar/vis_menu",$conn);
                                        if ($btn_vis) {
                                            ?>
                                            <a class="btn btn-outline-primary btn-sm" href="<?= pg."/visualizar/vis_menu?id=".$row_men['id']."" ?>">Visualizar</a>
                                            <?php
                                        }
                                    ?>  
                                    <?php
                                        $btn_apagar = carregarBtn("processa/apagar_menu",$conn);
                                        if ($btn_apagar) {
                                            ?>
                                            <a class="btn btn-outline-danger btn-sm" href="<?= pg."/processa/apagar_menu?id=".$row_men['id']."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                                                    <a class="dropdown-item" href="<?= pg."/listar/list_menu" ?>">Listar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_vis) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/visualizar/vis_menu?id=".$row_men['id']."" ?>">Visualizar</a>
                                                <?
                                            }
                                        ?>
                                        <?php
                                            if ($btn_apagar) {
                                                ?>
                                                    <a class="dropdown-item" href="<?= pg."/processa/apagar_menu?id=".$row_men['id']."" ?>" data-confirm="Tem certeza que deseja excluir o item seleconado?">Apagar</a>
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
                            <form method="POST" action="<?= pg; ?>/processa/proc_edit_menu">
                                <input type="hidden" name="id" value="<?= ( isset($row_men['id'])) ? $row_men['id'] : ''?>">
                                <div class="form-group col-md-12">
                                    <span class="text-danger">* </span>
                                    <label>
                                        <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                                title="Nome do itém do menu a ser cadastrado">
                                                <i class="fas fa-question-circle"></i>
                                        </span>
                                        Nome:
                                    </label>
                                    <input name="nome" type="text" class="form-control" 
                                    value="<?php 
                                        if(isset($_SESSION['dados']['nome'])) { 
                                            echo $_SESSION['dados']['nome']; } else {
                                                echo $row_men['nome'];
                                            }
                                        ?>"
                                    id="nome" placeholder="Nome do nível itém do menu">
                                </div>
                                <div class="form-group col-md-12">
                                    <span class="text-danger">* </span>
                                    <label>
                                        <span tabindex="0" data-placement="top" data-toggle="tooltip" data-html="true" title="Página de ícone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>.
                                            Somente inserir o nome, EX: fas fa-volume-up">
                                                <i class="fas fa-question-circle"></i>
                                        </span>
                                        Ícone:
                                    </label>
                                    <input name="icone" type="text" class="form-control" 
                                    value="<?php if(isset($_SESSION['dados']['icone'])) { echo $_SESSION['dados']['icone']; } else { echo $row_men['icone']; } ?>"
                                    id="icone" placeholder="Digite o ícone da página">
                                </div>
                                <div class="form-group col-md-12">
                                    <?php
                                        $result_sit = "SELECT id, nome FROM adms_sits ORDER BY nome ASC";
                                        $resultado_sit = mysqli_query($conn, $result_sit);
                                    ?>
                                    <label>
                                        <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                            title="A situação do menu ex: Ativa">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                        <span class="text-danger">*</span>  Situação
                                    </label>
                                    <select name="adms_sit_id" id="adms_sit_id" class="form-control">
                                        <option value=""> Selecione</option>
                                        <?php
                                            while($row_sit = mysqli_fetch_assoc($resultado_sit)) {
                                                if (isset($_SESSION['dados']['adms_sit_id']) && ($_SESSION['dados']['adms_sit_id'] == $row_sit['id'])) {

                                                    echo "<option selected value='".$row_sit['id']."'>".$row_sit['nome']."</option>";

                                                } elseif( !isset($_SESSION['dados']['adms_sit_id'])
                                                 && (isset($row_men['adms_sit_id'])
                                                 && ($row_men['adms_sit_id'] == $row_sit['id']) ) ) {
                                                    
                                                    echo "<option selected value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                                }else {
                                                    echo "<option value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                                }
                                            }

                                        ?> 
                                    </select>
                                </div>
                                
                                <p>
                                    <span class="text-danger">* </span>Campo obrigatório
                                </p>
                                <input name="SendEditMen" id="SendEditMen"  type="submit" class="btn btn-warning" value="Salvar"></input>
                            </form>
                        </div>
        
                    <?php           
                    include_once 'app/adms/include/rodape_lib.php'
                    ?>
                </div>
            </body>
        <?php
        unset($_SESSION['dados']);
        }else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
            $url_destino = pg.'/listar/list_pagina';
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
        $url_destino = pg.'/acesso/login';
        header("Location: $url_destino");
    }