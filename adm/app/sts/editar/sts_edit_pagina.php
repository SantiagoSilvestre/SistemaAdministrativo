<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(!empty($id)) {
        $result_edit_pg = "SELECT * FROM  sts_paginas WHERE id = '".$id."' LIMIT 1";
        $resultado_edit_pg = mysqli_query($conn, $result_edit_pg);

        if(($resultado_edit_pg) && ($resultado_edit_pg->num_rows != 0) ){
            $row_edit_pg = mysqli_fetch_assoc($resultado_edit_pg);
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
                            <h2 class="display-4 titulo">Editar Página STS</h2>
                        </div>
                        <div class="p-2">
                        <?php
                            $btn_list = carregarBtn("listar/sts_list_pagina",$conn);
                            if ($btn_list) {
                                ?>
                                <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_pagina" ?>"> Listar</a>
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
                    <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_pagina" enctype="multipart/form-data">
                        <input type="hidden" id="id" name="id" value="<?= $row_edit_pg['id'] ?>">
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Nome da página a ser apresentado no menu ou no Listar paginas">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Nome
                                </label>
                                <input name="nome_pagina" type="text" class="form-control" id="nome_pagina" 
                                value="<?php 
                                            if (isset($_SESSION['dados']['nome_pagina'])) { 
                                                echo $_SESSION['dados']['nome_pagina'];
                                             } else {
                                                 echo $row_edit_pg['nome_pagina'];
                                             }
                                        ?>"
                                placeholder="Nome da Página">
                            </div>
                            <div class="form-group col-md-4">
                                <label><span class="text-danger">*</span> Endereço</label>
                                <input name="endereco" type="text" class="form-control" id="endereco" 
                                value="<?php if(isset($_SESSION['dados']['endereco'])) { echo $_SESSION['dados']['endereco']; } else { echo $row_edit_pg['endereco'];} ?>"
                                placeholder="Endereço da página, ex: listar/sts_list_pagina">
                            </div>
                            <div class="form-group col-md-3">
                                <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" data-html="true" title="Título que vai aparecer no menu">
                                        <i class="fas fa-question-circle"></i>
                                </span>
                                Título</label>
                                <input name="titulo" type="text" class="form-control" id="titulo" 
                                value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } else { echo $row_edit_pg['titulo'];}  ?>"
                                placeholder="ícone da página">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Observação</label>
                            <textarea name="obs" class="form-control" id="obs"><?php if(isset($_SESSION['dados']['obs'])) { echo $_SESSION['dados']['obs']; } else { echo $row_edit_pg['obs'];}  ?></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                        title="Palavras chaves, para ajudar nas pesquisas das páginas">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Palavras chave
                                </label>
                                <input name="keywords" type="text" class="form-control" id="keywords" 
                                value="<?php if(isset($_SESSION['dados'])) { echo $_SESSION['dados']['keywords']; } else { echo $row_edit_pg['keywords'];}  ?>"
                                placeholder="palavra Chave">
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                        title="Coloque uma descrição na página para melhor identificação">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Descrição
                                </label>
                                <input name="description" type="text" class="form-control" id="description" 
                                value="<?php if(isset($_SESSION['dados'])) { echo $_SESSION['dados']['description']; } else { echo $row_edit_pg['description'];}  ?>"
                                placeholder="Descrição da página">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                        title="Coloque o nome do desenvolvedor da página">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span>  Autor
                                </label>
                                <input name="author" type="text" class="form-control" id="author" 
                                value="<?php if(isset($_SESSION['dados'])) { echo $_SESSION['dados']['author']; } else { echo $row_edit_pg['author'];}  ?>"
                                placeholder="Desenvolvedor">
                            </div>
                            <div class="form-group col-md-4">
                                <?php
                                    $result_robot = "SELECT id, nome FROM sts_robots";
                                    $resultado_robot = mysqli_query($conn, $result_robot);
                                ?>
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                        title="Se os navegadores vão incluir a página ou não nas buscas indexadas">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Indexar
                                </label>
                                <select name="sts_robot_id" id="sts_robot_id" class="form-control">
                                    <option value=""> Selecione</option>
                                    <?php
                                        while($row_robot = mysqli_fetch_assoc($resultado_robot)) {
                                            if (isset($_SESSION['dados']['sts_robot_id']) && ($_SESSION['dados']['sts_robot_id'] == $row_robot['id'])) {
                                                echo "<option selected value='".$row_robot['id']."'>".$row_robot['nome']."</option>";
                                            } else if (!isset($_SESSION['dados']['sts_robot_id']) && isset($row_edit_pg['sts_robot_id']) && $row_edit_pg['sts_robot_id'] == $row_robot['id'] ){
                                                echo "<option selected value='".$row_robot['id']."'>".$row_robot['nome']."</option>";
                                            } else {
                                                echo "<option value='".$row_robot['id']."'>".$row_robot['nome']."</option>";
                                            }
                                            
                                        }

                                    ?>                                
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                        title="Define se a página é liberada ou não para o público">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Bloqueada
                                </label>
                                <select name="lib_bloq" id="lib_bloq" class="form-control">
                                    <?php
                                        if (isset($_SESSION['dados']['lib_bloq']) && ($_SESSION['dados']['lib_bloq'] == '1') || (isset($row_edit_pg['lib_bloq']) && $row_edit_pg['lib_bloq'] == 1)) {
                                            echo "<option value=''> Selecione</option>";
                                            echo "<option selected value='1'>Sim</option>";
                                            echo "<option value='2'>Não</option>";
                                        } else if(isset($_SESSION['dados']['lib_bloq']) && ($_SESSION['dados']['lib_bloq'] == '2') || (isset($row_edit_pg['lib_bloq']) && $row_edit_pg['lib_bloq'] == 2)) {
                                            echo "<option value=''> Selecione</option>";
                                            echo "<option value='1'>Sim</option>";
                                            echo "<option selected value='2'>Não</option>";
                                        } else {
                                            echo "<option value='' selected> Selecione</option>";
                                            echo "<option value='1'>Sim</option>";
                                            echo "<option value='2'>Não</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                        <div class="form-group col-md-4">
                                <?php
                                    $result_paginas = "SELECT id, nome_pagina FROM sts_paginas ORDER BY nome_pagina ASC";
                                    $resultado_paginas = mysqli_query($conn, $result_paginas);
                                ?>
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                        title="Define qual é a página dependente">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span>  Página Dependente
                                </label>
                                <select name="depend_pg" id="depend_pg" class="form-control">
                                    <option value=""> Selecione</option>
                                    <?php
                                        if ((isset($_SESSION['dados']['depend_pg']) && ($_SESSION['dados']['depend_pg'] == 0)) || ($row_edit_pg['depend'] == 0) ) {
                                            echo "<option selected value='0'>A página não depende de nenhuma outra Página</option>";
                                        } else {
                                            echo "<option value='0'>A página não depende de nenhuma outra Página</option>";
                                        }
                                        while($row_pagina = mysqli_fetch_assoc($resultado_paginas)) {
                                            if (isset($_SESSION['dados']['depend_pg']) && ($_SESSION['dados']['depend_pg'] == $row_pagina['id'])) {
                                                echo "<option selected value='".$row_pagina['id']."'>".$row_pagina['nome_pagina']."</option>";
                                            } else if (!isset($_SESSION['dados']['depend_pg']) && isset($row_edit_pg['depend_pg']) && $row_edit_pg['depend_pg'] == $row_pagina['id'] ){
                                                echo "<option selected value='".$row_pagina['id']."'>".$row_pagina['nome_pagina']."</option>";
                                            } else {
                                                echo "<option value='".$row_pagina['id']."'>".$row_pagina['nome_pagina']."</option>";
                                            }
                                        }

                                    ?> 
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <?php
                                    $result_tip = "SELECT id, tipo, nome FROM sts_tps_pgs ORDER BY nome ASC";
                                    $resultado_tip = mysqli_query($conn, $result_tip);
                                ?>
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                        title="Define qual o tipo de página">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span> Tipo
                                </label>
                                <select name="sts_tps_pgs_id" id="sts_tps_pgs_id" class="form-control">
                                    <option value=""> Selecione</option>
                                    <?php
                                        while($row_tip = mysqli_fetch_assoc($resultado_tip)) {
                                            if (isset($_SESSION['dados']['sts_tps_pgs_id']) && ($_SESSION['dados']['sts_tps_pgs_id'] == $row_tip['id'])) {
                                                echo "<option selected value='".$row_tip['id']."'>". $row_tip['tipo']." - ".$row_tip['nome']."</option>";
                                            } else if (!isset($_SESSION['dados']['sts_tps_pgs_id']) && isset($row_edit_pg['sts_tps_pgs_id']) && $row_edit_pg['sts_tps_pgs_id'] == $row_tip['id'] ){
                                                echo "<option selected value='".$row_tip['id']."'>". $row_tip['tipo']." - ".$row_tip['nome']."</option>";
                                            } else {
                                                echo "<option value='".$row_tip['id']."'>". $row_tip['tipo']." - ".$row_tip['nome']."</option>";
                                            }
                                        }

                                    ?> 
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <?php
                                    $result_sit = "SELECT id, nome FROM sts_situacaos_pgs ORDER BY nome ASC";
                                    $resultado_sit = mysqli_query($conn, $result_sit);
                                ?>
                                <label>
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                        title="A situação da página ex: Ativa">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                    <span class="text-danger">*</span>  Situação
                                </label>
                                <select name="sts_situacaos_pg_id" id="sts_situacaos_pg_id" class="form-control">
                                    <option value=""> Selecione</option>
                                    <?php
                                        while($row_sit = mysqli_fetch_assoc($resultado_sit)) {
                                            if (isset($_SESSION['dados']['sts_situacaos_pg_id']) && ($_SESSION['dados']['sts_situacaos_pg_id'] == $row_sit['id'])) {
                                                echo "<option selected value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                            } else if (!isset($_SESSION['dados']['sts_situacaos_pg_id']) && isset($row_edit_pg['sts_situacaos_pg_id']) && $row_edit_pg['sts_situacaos_pg_id'] == $row_sit['id'] ){
                                                echo "<option selected value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                            } else {
                                                echo "<option value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                            }
                                        }

                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <input type="hidden" name="imagem_antiga" value="<?php echo $row_edit_pg['imagem']; ?>">
                            <div class="form-group col-md-6">
                                <label>Foto </label>
                                <input name="imagem" type="file" id="imagem" onchange="previewImage()">
                            </div>
                            <div class="form-group col-md-6">
                                <?php
                                if (isset($row_edit_pg['imagem'])) {
                                    $imagem_antiga = pgsite . '/assets/imagens/paginas/'.$row_edit_pg['id'].'/'.$row_edit_pg['imagem'];
                                }else{
                                   $imagem_antiga  = pgsite.'/assets/imagens/default.png'; 
                                }
                                ?>
                                <img src="<?= $imagem_antiga ?>" id="preview-user" class="img-thumbnail" style="width: 287px; heith: 150px;">
                            </div>
                        </div>
                        <p>
                            <span class="text-danger">* </span>Campo obrigatório
                        </p>
                        <input name="SendStsEditPg" id="SendStsEditPg"  type="submit" class="btn btn-warning" value="Salvar"></input>
                    </form>
                </div>
            <?php  
                unset($_SESSION['dados']);         
                include_once 'app/adms/include/rodape_lib.php'
            ?>
            <script>
                function previewImage() {
                    var imagem = document.querySelector('input[name=imagem]').files[0];
                    var preview = document.querySelector('#preview-user');

                    var reader = new FileReader();

                    reader.onloadend = function () {
                        preview.src = reader.result;
                    }

                    if (imagem) {
                        reader.readAsDataURL(imagem);
                    } else {
                        preview.src = "";
                    }

                }
            </script>
        </div>
    </body>
    <?php
    unset($_SESSION['dados']);
        }else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
            $url_destino = pg.'/listar/sts_list_carousels';
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
        $url_destino = pg.'/acesso/login';
        header("Location: $url_destino");
    }
    ?>
