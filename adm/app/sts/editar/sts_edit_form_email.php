<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
    include_once 'app/adms/include/head.php';
        $result_edit_form_email = "SELECT * FROM  sts_forms_emails LIMIT 1";
        $resultado_edit_form_email = mysqli_query($conn, $result_edit_form_email);
        
        if(($resultado_edit_form_email) && ($resultado_edit_form_email->num_rows != 0) ){
            $row_edit_form_email = mysqli_fetch_assoc($resultado_edit_form_email);
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
                        <h2 class="display-4 titulo">Editar formulário de envio de E-mal STS</h2>
                    </div>
                </div>
                <hr>
                <?php
                    if(isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_form_email" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="<?= $row_edit_form_email['id'] ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <span class="text-danger">* </span>
                            <label> Título </label>
                            <input name="titulo" type="text" class="form-control" id="titulo" 
                            value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } else { echo $row_edit_form_email['titulo'];} ?>"
                            placeholder="Título do form_email">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <span class="text-danger">* </span>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no form_email para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Descrição
                            </label>
                            <input name="descricao" type="text" class="form-control" id="descricao" 
                            value="<?php if(isset($_SESSION['dados']['descricao'])) { echo $_SESSION['dados']['descricao']; } else { echo $row_edit_form_email['descricao'];} ?>"
                            placeholder="Título do form_email">                        </div>
                        <div class="form-group col-md-4">
                            <span class="text-danger">* </span>
                            <label> Título do botão </label>
                            <input name="titulo_botao" type="text" class="form-control" id="titulo_botao" 
                            value="<?php if(isset($_SESSION['dados']['titulo_botao'])) { echo $_SESSION['dados']['titulo_botao']; } else { echo $row_edit_form_email['titulo_botao'];} ?>"
                            placeholder="Título do form_email">
                        </div>
                    </div>
                    <div class="form-row">
                        <input type="hidden" name="imagem_antiga" value="<?php echo $row_edit_form_email['imagem']; ?>">
                        <div class="form-group col-md-6">
                            <label>Foto </label>
                            <input name="imagem" type="file" id="imagem" onchange="previewImage()">
                        </div>
                            <?php
                                if (isset($row_edit_form_email['imagem'])) {
                                    $imagem_antiga = pgsite . '/assets/imagens/form_email/'.$row_edit_form_email['id'].'/'.$row_edit_form_email['imagem'];
                                }else{
                                   $imagem_antiga  = pgsite.'/assets/imagens/paginas/default.png'; 
                                }
                            ?>
                        <div class="form-group col-md-6">
                            <img src="<?= $imagem_antiga?>" id="preview-user" class="img-thumbnail" style="width: 287px; heith: 150px;">
                        </div>
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendStsEditformEmail" id="SendStsEditformEmail"  type="submit" class="btn btn-warning" value="Salvar"></input>
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
            $url_destino = pg.'/listar/sts_list_form_emails';
            header("Location: $url_destino");
        }