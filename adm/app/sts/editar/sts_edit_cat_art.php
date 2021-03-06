<?php 
    if(!isset($seg)){
        exit;
    }
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(!empty($id)) {
        $result_cat_art = "SELECT * FROM sts_cats_artigos WHERE id = '".$id."' LIMIT 1";
       
        $resultado_cat_art = mysqli_query($conn, $result_cat_art);

        if(($resultado_cat_art) && ($resultado_cat_art->num_rows != 0) ){
            $row_cat_art = mysqli_fetch_assoc($resultado_cat_art);
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
                                    <h2 class="display-4 titulo">Editar Categoria</h2>
                                </div>
                                <div class="p-2">
                                <?php
                                    $btn_list = carregarBtn("listar/sts_list_cat_artigo",$conn);
                                    if ($btn_list) {
                                        ?>
                                        <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_cat_artigo" ?>"> Listar</a>
                                        <?php
                                    }
                                ?>
                                </div>
                            </div>
                            <hr>
                            <?php
                                if(isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                            ?>
                            <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_cat_art">
                                <input type="hidden" id="id" name="id" value="<?= $row_cat_art['id'] ?>">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>
                                            <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                            title="Nome, auto-explicativo">
                                                <i class="fas fa-question-circle"></i>
                                            </span>
                                            <span class="text-danger">*</span> Nome
                                        </label>
                                        <input name="nome" type="text" class="form-control" id="nome" 
                                        value="<?php if(isset($_SESSION['dados']['nome'])) { echo $_SESSION['dados']['nome']; } else { echo $row_cat_art['nome'];} ?>"
                                        placeholder="Digite o nome">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <?php
                                            $result_sit_per = "SELECT id, nome FROM sts_situacoes ORDER BY nome ASC";
                                            $resultado_sit_per = mysqli_query($conn, $result_sit_per);
                                        ?>
                                        <label>
                                            <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                                title="Define qual se a pergunta vai aparecer no site ou não">
                                                <i class="fas fa-question-circle"></i>
                                            </span> Situação
                                        </label>
                                        <select name="sts_situacoe_id" id="sts_situacoe_id" class="form-control">
                                            <option value=""> Selecione</option>
                                            <?php
                                                while($row_sit_per = mysqli_fetch_assoc($resultado_sit_per)) {
                                                    if (isset($_SESSION['dados']['sts_situacoe_id']) && ($_SESSION['dados']['sts_situacoe_id'] == $row_sit_per['id'])) {
                                                        echo "<option selected value='".$row_sit_per['id']."'>".$row_sit_per['nome']."</option>";
                                                    } else if ( !(isset($_SESSION['dados']['sts_situacoe_id'])) && ($row_sit_per['id'] == $row_cat_art['sts_situacoe_id'])) {
                                                        echo "<option selected value='".$row_sit_per['id']."'>".$row_sit_per['nome']."</option>";
                                                    } else {
                                                        echo "<option value='".$row_sit_per['id']."'>".$row_sit_per['nome']."</option>";
                                                    }
                                                }

                                            ?> 
                                        </select>
                                    </div>
                                </div>
                                <p>
                                    <span class="text-danger">* </span>Campo obrigatório
                                </p>
                                <input name="SendStsEditCatArt" id="SendStsEditCatArt"  type="submit" class="btn btn-warning" value="Salvar"></input>
                            </form>
                        </div>
                    <?php          
                        include_once 'app/adms/include/rodape_lib.php'
                    ?>
                </div>
            </body>
            <?php
            unset($_SESSION['dados']);
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
            $url_destino = pg.'/listar/sts_list_cat_artigo';
            header("Location: $url_destino");
        }
    } else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
    }
?>