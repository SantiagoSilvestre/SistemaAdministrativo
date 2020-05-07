<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
    include_once 'app/adms/include/head.php';
        $result_edit_produto = "SELECT * FROM  sts_prods_homes LIMIT 1";
        $resultado_edit_produto = mysqli_query($conn, $result_edit_produto);
        
        if(($resultado_edit_produto) && ($resultado_edit_produto->num_rows != 0) ){
            $row_edit_produto = mysqli_fetch_assoc($resultado_edit_produto);
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
                        <h2 class="display-4 titulo">Editar Produto STS</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("listar/sts_list_produtos",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_produtos" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_produto" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="<?= $row_edit_produto['id'] ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <span class="text-danger">* </span>
                            <label> Título </label>
                            <input name="titulo" type="text" class="form-control" id="titulo" 
                            value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } else { echo $row_edit_produto['titulo'];} ?>"
                            placeholder="Título do produto">
                        </div>
                        <div class="form-group col-md-6">
                            <span class="text-danger">* </span>
                            <label> Sub - Título </label>
                            <input name="subtitulo" type="text" class="form-control" id="subtitulo" 
                            value="<?php if(isset($_SESSION['dados']['subtitulo'])) { echo $_SESSION['dados']['subtitulo']; } else { echo $row_edit_produto['subtitulo'];} ?>"
                            placeholder="Título do produto">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <span class="text-danger">* </span>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no produto para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Descrição
                            </label>
                            <textarea name="descricao" type="text" class="form-control" id="descricao"><?php if(isset($_SESSION['dados']['descricao'])) { echo $_SESSION['dados']['descricao']; } else { echo $row_edit_produto['descricao'];} ?> </textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <input type="hidden" name="imagem_antiga" value="<?php echo $row_edit_produto['imagem']; ?>">
                        <div class="form-group col-md-6">
                            <label>Foto </label>
                            <input name="imagem" type="file" id="imagem" onchange="previewImage()">
                        </div>
                            <?php
                                if (isset($row_edit_produto['imagem'])) {
                                    $imagem_antiga = pgsite . '/assets/imagens/prods_home/'.$row_edit_produto['id'].'/'.$row_edit_produto['imagem'];
                                }else{
                                   $imagem_antiga  = pgsite.'/assets/imagens/default.png'; 
                                }
                            ?>
                        <div class="form-group col-md-6">
                            <img src="<?= $imagem_antiga?>" id="preview-user" class="img-thumbnail" style="width: 287px; heith: 150px;">
                        </div>
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendStsEditproduto" id="SendStsEditproduto"  type="submit" class="btn btn-warning" value="Salvar"></input>
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
            $url_destino = pg.'/listar/sts_list_produtos';
            header("Location: $url_destino");
        }