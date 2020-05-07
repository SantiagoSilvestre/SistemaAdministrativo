<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(!empty($id)) {
        $result_contato = "SELECT * FROM sts_contatos WHERE id = '".$id."' LIMIT 1";
       
        $resultado_contato = mysqli_query($conn, $result_contato);

        if(($resultado_contato) && ($resultado_contato->num_rows != 0) ){
            $row_contato = mysqli_fetch_assoc($resultado_contato);
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
                        <h2 class="display-4 titulo">Editar Mensagem de Contato</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("listar/sts_list_contato",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_contato" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_contato">
                    <input type="hidden" id="id" name="id" value ="<?= $row_contato['id']?>">
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
                            value="<?php if(isset($_SESSION['dados']['nome'])) { echo $_SESSION['dados']['nome']; } else { echo $row_contato['nome'];} ?>"
                            placeholder="Digite o nome">
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                title="Nome, auto-explicativo">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> E-mail
                            </label>
                            <input name="email" type="email" class="form-control" id="email" 
                            value="<?php if(isset($_SESSION['dados']['email'])) { echo $_SESSION['dados']['email']; } else { echo $row_contato['email'];} ?>"
                            placeholder="Digite o seu melhor e-mail">
                        </div>
                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                title="Assunto da mensagem, auto-explicativo">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Assunto
                            </label>
                            <input name="assunto" type="text" class="form-control" id="assunto" 
                            value="<?php if(isset($_SESSION['dados']['assunto'])) { echo $_SESSION['dados']['assunto']; } else { echo $row_contato['assunto'];}?>"
                            placeholder="Digite o assunto">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque a mensagem para enviar">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Mensagem
                            </label>
                            <textarea name="mensagem" class="form-control" id="mensagem"><?php if(isset($_SESSION['dados']['mensagem'])) { echo $_SESSION['dados']['mensagem']; }else { echo $row_contato['mensagem'];} ?></textarea>
                        </div>
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendStsEditContato" id="SendStsEditContato"  type="submit" class="btn btn-warning" value="Salva"></input>
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
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
            $url_destino = pg.'/listar/sts_list_contatos';
            header("Location: $url_destino");
        }
    } else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
    }
?>