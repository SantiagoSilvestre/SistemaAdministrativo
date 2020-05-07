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
                        <h2 class="display-4 titulo">Cadastrar Itém de Menu</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("listar/list_menu",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/list_menu" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_cad_menu">
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
                        value="<?php if(isset($_SESSION['dados']['nome'])) { echo $_SESSION['dados']['nome']; } ?>"
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
                        value="<?php if(isset($_SESSION['dados']['icone'])) { echo $_SESSION['dados']['icone']; } ?>"
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
                                        } else {
                                            echo "<option value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadMenu" id="SendCadMenu"  type="submit" class="btn btn-success" value="Cadastrar"></input>
                </form>
            </div>
        <?php  
            unset($_SESSION['dados']);         
            include_once 'app/adms/include/rodape_lib.php'
        ?>
    </div>
</body>
