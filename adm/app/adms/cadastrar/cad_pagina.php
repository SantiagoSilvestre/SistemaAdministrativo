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
                        <h2 class="display-4 titulo">Cadastrar Página</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("listar/list_pagina",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/list_pagina" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_cad_pagina">
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
                            value="<?php if(isset($_SESSION['dados']['nome_pagina'])) { echo $_SESSION['dados']['nome_pagina']; } ?>"
                            placeholder="Nome da Página">
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> Endereço</label>
                            <input name="endereco" type="text" class="form-control" id="endereco" 
                            value="<?php if(isset($_SESSION['dados']['endereco'])) { echo $_SESSION['dados']['endereco']; } ?>"
                            placeholder="Endereço da página, ex: listar/list_pagina">
                        </div>
                        <div class="form-group col-md-3">
                            <label>
                            <span tabindex="0" data-placement="top" data-toggle="tooltip" data-html="true" title="Página de ícone: <a href='https://fontawesome.com/icons?d=gallery' target='_blank'>fontawesome</a>.
                                Somente inserir o nome, EX: fas fa-volume-up">
                                    <i class="fas fa-question-circle"></i>
                            </span>
                             Ícone</label>
                            <input name="icone" type="text" class="form-control" id="icone" 
                            value="<?php if(isset($_SESSION['dados']['icone'])) { echo $_SESSION['dados']['icone']; } ?>"
                            placeholder="ícone da página">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Observação</label>
                        <textarea name="obs" class="form-control" id="obs"><?php if(isset($_SESSION['dados']['obs'])) { echo $_SESSION['dados']['obs']; } ?></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Palavras chaves, para ajudar nas pesquisas das páginas">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Palavras chave
                            </label>
                            <input name="keywords" type="text" class="form-control" id="keywords" 
                            value="<?php if(isset($_SESSION['dados'])) { echo $_SESSION['dados']['keywords']; } ?>"
                            placeholder="palavra Chave">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição na página para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Descrição
                            </label>
                            <input name="description" type="text" class="form-control" id="description" 
                            value="<?php if(isset($_SESSION['dados'])) { echo $_SESSION['dados']['description']; } ?>"
                            placeholder="Descrição da página">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque o nome do desenvolvedor da página">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span>  Autor
                            </label>
                            <input name="author" type="text" class="form-control" id="author" 
                            value="<?php if(isset($_SESSION['dados'])) { echo $_SESSION['dados']['author']; } ?>"
                            placeholder="Desenvolvedor">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <?php
                                $result_robot = "SELECT id, nome FROM adms_robot";
                                $resultado_robot = mysqli_query($conn, $result_robot);
                            ?>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Se os navegadores vão incluir a página ou não nas buscas indexadas">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Indexar
                            </label>
                            <select name="adms_robot_id" id="adms_robot_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_robot = mysqli_fetch_assoc($resultado_robot)) {
                                        if (isset($_SESSION['dados']['adms_robot_id']) && ($_SESSION['dados']['adms_robot_id'] == $row_robot['id'])) {
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
                                    title="Define se a página é liberada para o público ou não">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Página pública
                            </label>
                            <select name="lib_pub" id="lib_pub" class="form-control">
                                <?php
                                    if (isset($_SESSION['dados']['lib_pub']) && ($_SESSION['dados']['lib_pub'] == '1')) {
                                        echo "<option value=''> Selecione</option>";
                                        echo "<option selected value='1'>Sim</option>";
                                        echo "<option value='2'>Não</option>";
                                    } else if(isset($_SESSION['dados']['lib_pub']) && ($_SESSION['dados']['lib_pub'] == '2')) {
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
                        <div class="form-group col-md-4">
                            <?php
                                $result_paginas = "SELECT id, nome_paginas FROM adms_paginas ORDER BY nome_paginas ASC";
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
                                    if (isset($_SESSION['dados']['depend_pg']) && ($_SESSION['dados']['depend_pg'] == 0)) {
                                        echo "<option selected value='0'>A página não depende de nenhuma outra Página</option>";
                                    } else {
                                        echo "<option value='0'>A página não depende de nenhuma outra Página</option>";
                                    }
                                    while($row_pagina = mysqli_fetch_assoc($resultado_paginas)) {
                                        if (isset($_SESSION['dados']['depend_pg']) && ($_SESSION['dados']['depend_pg'] == $row_pagina['id'])) {
                                            echo "<option selected value='".$row_pagina['id']."'>".$row_pagina['nome_paginas']."</option>";
                                        } else {
                                            echo "<option value='".$row_pagina['id']."'>".$row_pagina['nome_paginas']."</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <?php
                                $result_grup = "SELECT id, nome FROM adms_grp_pgs ORDER BY nome ASC";
                                $resultado_grup = mysqli_query($conn, $result_grup);
                            ?>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Seleciona o grupo a qual a página vai pertencer">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Grupo
                            </label>
                            <select name="adms_grps_pg_id" id="adms_grps_pg_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_grup = mysqli_fetch_assoc($resultado_grup)) {
                                        if (isset($_SESSION['dados']['adms_grps_pg_id']) && ($_SESSION['dados']['adms_grps_pg_id'] == $row_grup['id'])) {
                                            echo "<option selected value='".$row_grup['id']."'>".$row_grup['nome']."</option>";
                                        } else {
                                            echo "<option value='".$row_grup['id']."'>".$row_grup['nome']."</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                                $result_tip = "SELECT id, tipo, nome FROM adms_tps_pg ORDER BY nome ASC";
                                $resultado_tip = mysqli_query($conn, $result_tip);
                            ?>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Define qual o tipo de página">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Tipo
                            </label>
                            <select name="adms_tps_pg_id" id="adms_tps_pg_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_tip = mysqli_fetch_assoc($resultado_tip)) {
                                        if (isset($_SESSION['dados']['adms_tps_pg_id']) && ($_SESSION['dados']['adms_tps_pg_id'] == $row_tip['id'])) {
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
                                $result_sit = "SELECT id, nome FROM adms_sits_pg ORDER BY nome ASC";
                                $resultado_sit = mysqli_query($conn, $result_sit);
                            ?>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="A situação da página ex: Ativa">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span>  Situação
                            </label>
                            <select name="adms_sits_pg_id" id="adms_sits_pg_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_sit = mysqli_fetch_assoc($resultado_sit)) {
                                        if (isset($_SESSION['dados']['adms_sits_pg_id']) && ($_SESSION['dados']['adms_sits_pg_id'] == $row_sit['id'])) {
                                            echo "<option selected value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                        } else {
                                            echo "<option value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadPg" id="SendCadPg"  type="submit" class="btn btn-success" value="Cadastrar"></input>
                </form>
            </div>
        <?php  
            unset($_SESSION['dados']);         
            include_once 'app/adms/include/rodape_lib.php'
        ?>
    </div>
</body>
