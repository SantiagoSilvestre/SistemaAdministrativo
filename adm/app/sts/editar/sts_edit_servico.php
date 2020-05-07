<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
    include_once 'app/adms/include/head.php';
   
    
    $result_edit_servico = "SELECT * FROM  sts_servicos LIMIT 1";
    $resultado_edit_servico = mysqli_query($conn, $result_edit_servico);
    
    if(($resultado_edit_servico) && ($resultado_edit_servico->num_rows != 0) ){
        $row_edit_servico = mysqli_fetch_assoc($resultado_edit_servico);
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
                        <h2 class="display-4 titulo">Editar servico STS</h2>
                    </div>
                </div>
                <hr>
                <?php
                    if(isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_servico">
                    <input type="hidden" id="id" name="id" value="<?= $row_edit_servico['id'] ?>">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                title="Nome do servico, auto-explicativo">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Titulo
                            </label>
                            <input name="titulo" type="text" class="form-control" id="titulo" 
                            value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } else { echo $row_edit_servico['titulo'];} ?>"
                            placeholder="Título dos serviços">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no servico para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Nome do serviço um
                            </label>
                            <input name="nome_um" type="text" class="form-control" id="nome_um" 
                            value="<?php if(isset($_SESSION['dados']['nome_um'])) { echo $_SESSION['dados']['nome_um']; } else { echo $row_edit_servico['nome_um'];} ?>"
                            placeholder="Nome do serviço 1">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no servico para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Descrição do serviço um
                            </label>
                            <input name="descricao_um" type="text" class="form-control" id="descricao_um" 
                            value="<?php if(isset($_SESSION['dados']['descricao_um'])) { echo $_SESSION['dados']['descricao_um']; } else { echo $row_edit_servico['descricao_um'];} ?>"
                            placeholder="Descrição do Serviço">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" data-html="true" title="Página de ícone: <a href='https://ionicons.com/' target='_blank'>Ionicons</a>.
                                    Somente inserir o nome, EX: fas fa-volume-up">
                                        <i class="fas fa-question-circle"></i>
                                </span>
                                Ícone 1
                            </label>
                            <input name="icone_um" type="text" class="form-control" id="icone_um" 
                            value="<?php if(isset($_SESSION['dados']['icone_um'])) { echo $_SESSION['dados']['icone_um']; } else { echo $row_edit_servico['icone_um'];} ?>"
                            placeholder="icone ex: fa fas-edit">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no servico para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Nome do serviço dois 
                            </label>
                            <input name="nome_dois" type="text" class="form-control" id="nome_dois" 
                            value="<?php if(isset($_SESSION['dados']['nome_dois'])) { echo $_SESSION['dados']['nome_dois']; } else { echo $row_edit_servico['nome_dois'];} ?>"
                            placeholder="Nome dois">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no servico para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Descrição do serviço dois
                            </label>
                            <input name="descricao_dois" type="text" class="form-control" id="descricao_dois" 
                            value="<?php if(isset($_SESSION['dados']['descricao_dois'])) { echo $_SESSION['dados']['descricao_dois']; } else { echo $row_edit_servico['descricao_dois'];} ?>"
                            placeholder="Descrição do serviço dois">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" data-html="true" title="Página de ícone: <a href='https://ionicons.com/' target='_blank'>Ionicons</a>.
                                    Somente inserir o nome, EX: fas fa-volume-up">
                                        <i class="fas fa-question-circle"></i>
                                </span>
                                Ícone dois
                            </label>
                            <input name="icone_dois" type="text" class="form-control" id="icone_dois" 
                            value="<?php if(isset($_SESSION['dados']['icone_dois'])) { echo $_SESSION['dados']['icone_dois']; } else { echo $row_edit_servico['icone_dois'];} ?>"
                            placeholder="icone ex: fa fas-edit">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no servico para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Nome do serviço três
                            </label>
                            <input name="nome_tres" type="text" class="form-control" id="nome_tres" 
                            value="<?php if(isset($_SESSION['dados']['nome_tres'])) { echo $_SESSION['dados']['nome_tres']; } else { echo $row_edit_servico['nome_tres'];} ?>"
                            placeholder="Nome do serviço três">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no servico para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Descrição do serviço três
                            </label>
                            <input name="descricao_tres" type="text" class="form-control" id="descricao_tres" 
                            value="<?php if(isset($_SESSION['dados']['descricao_tres'])) { echo $_SESSION['dados']['descricao_tres']; } else { echo $row_edit_servico['descricao_tres'];} ?>"
                            placeholder="Descrição do serviço três">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" data-html="true" title="Página de ícone: <a href='https://ionicons.com/' target='_blank'>Ionicons</a>.
                                    Somente inserir o nome, EX: fas fa-volume-up">
                                        <i class="fas fa-question-circle"></i>
                                </span>
                                Ícone três
                            </label>
                            <input name="icone_tres" type="text" class="form-control" id="icone_tres" 
                            value="<?php if(isset($_SESSION['dados']['icone_tres'])) { echo $_SESSION['dados']['icone_tres']; } else { echo $row_edit_servico['icone_tres'];} ?>"
                            placeholder="icone ex: fa fas-edit">
                        </div>
                    </div>
                    
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendStsEditServico" id="SendStsEditServico"  type="submit" class="btn btn-warning" value="Salvar"></input>
                </form>
            </div>
        <?php  
            unset($_SESSION['dados']);         
            include_once 'app/adms/include/rodape_lib.php'
        ?>
    </div>
</body>
<?php
    unset($_SESSION['dados']);
    }else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
        $url_destino = pg.'/listar/sts_list_carousels';
        header("Location: $url_destino");
    }
   