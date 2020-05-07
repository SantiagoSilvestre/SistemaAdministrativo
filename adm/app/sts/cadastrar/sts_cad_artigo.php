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
                        <h2 class="display-4 titulo">Cadastrar Artigo</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("listar/sts_list_artigos",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_artigos" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_cad_artigo" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                title="Título a ser apresentado no menu ou no Listar artigos">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Título
                            </label>
                            <input name="titulo" type="text" class="form-control" id="titulo" 
                            value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } ?>"
                            placeholder="Título do artigo">
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> Slug</label>
                            <input name="slug" type="text" class="form-control" id="slug" 
                            value="<?php if(isset($_SESSION['dados']['slug'])) { echo $_SESSION['dados']['slug']; } ?>"
                            placeholder="Slug">
                        </div>
                        <div class="form-group col-md-4">
                            <span class="text-danger">*</span>
                            <label>Autor</label>
                            <input name="author" type="text" class="form-control" id="author" 
                            value="<?php if(isset($_SESSION['dados']['author'])) { echo $_SESSION['dados']['author']; } ?>"
                            placeholder="Autor do artigo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Resumo Público</label>
                        <textarea name="resumo_publico" class="form-control" id="editor1"><?php if(isset($_SESSION['dados']['resumo_publico'])) { echo $_SESSION['dados']['resumo_publico']; } ?></textarea>
                    </div>
                    <div class="form-group">
                        <span class="text-danger">*</span>
                        <label>Breve Descrição</label>
                        <textarea name="description" class="form-control" id="editor2"><?php if(isset($_SESSION['dados']['description'])) { echo $_SESSION['dados']['description']; } ?></textarea>
                    </div>
                    <div class="form-group">
                        <span class="text-danger">*</span>
                        <label>Descrição</label>
                        <textarea name="descricao" class="form-control" id="editor3"><?php if(isset($_SESSION['dados']['descricao'])) { echo $_SESSION['dados']['descricao']; } ?></textarea>
                    </div>
                    <div class="form-group">
                        <span class="text-danger">*</span>
                        <label>Conteúdo</label>
                        <textarea name="conteudo" class="form-control" id="editor4"><?php if(isset($_SESSION['dados']['conteudo'])) { echo $_SESSION['dados']['conteudo']; } ?></textarea>
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
                                        } else {
                                            echo "<option value='".$row_robot['id']."'>".$row_robot['nome']."</option>";
                                        }
                                        
                                    }

                                ?>                                
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                                $result_user = "SELECT id, nome FROM adms_usuarios";
                                $resultado_user = mysqli_query($conn, $result_user);
                            ?>
                            <label>
                                <span class="text-danger">*</span> Usuário
                            </label>
                            <select name="adms_usuario_id" id="adms_usuario_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_user = mysqli_fetch_assoc($resultado_user)) {
                                        if (isset($_SESSION['dados']['adms_usuario_id']) && ($_SESSION['dados']['adms_usuario_id'] == $row_user['id'])) {
                                            echo "<option selected value='".$row_user['id']."'>".$row_user['nome']."</option>";
                                        } else {
                                            echo "<option value='".$row_user['id']."'>".$row_user['nome']."</option>";
                                        }
                                        
                                    }

                                ?>                                
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <?php
                                $result_tp_artigo = "SELECT id, nome FROM sts_tps_artigos ORDER BY nome ASC";
                                $resultado_tp_artigo = mysqli_query($conn, $result_tp_artigo);
                            ?>
                            <label>
                                <span class="text-danger">*</span> Tipo de Artigo
                            </label>
                            <select name="sts_tps_artigo_id" id="sts_tps_artigo_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_tp_artigo = mysqli_fetch_assoc($resultado_tp_artigo)) {
                                        if (isset($_SESSION['dados']['sts_tps_artigo_id']) && ($_SESSION['dados']['sts_tps_artigo_id'] == $row_tp_artigo['id'])) {
                                            echo "<option selected value='".$row_tp_artigo['id']."'>".$row_tp_artigo['nome']."</option>";
                                        } else {
                                            echo "<option value='".$row_tp_artigo['id']."'>".$row_tp_artigo['nome']."</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                                $result_cat_artigo = "SELECT id, nome FROM sts_cats_artigos ORDER BY nome ASC";
                                $resultado_cat_artigo = mysqli_query($conn, $result_cat_artigo);
                            ?>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Define qual o tipo de página">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Categoria
                            </label>
                            <select name="sts_cats_artigo_id" id="sts_cats_artigo_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_cat_artigo = mysqli_fetch_assoc($resultado_cat_artigo)) {
                                        if (isset($_SESSION['dados']['sts_cats_artigo_id']) && ($_SESSION['dados']['sts_cats_artigo_id'] == $row_cat_artigo['id'])) {
                                            echo "<option selected value='".$row_cat_artigo['id']."'>".$row_cat_artigo['nome']."</option>";
                                        } else {
                                            echo "<option value='".$row_cat_artigo['id']."'>".$row_cat_artigo['nome']."</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <?php
                                $result_sit = "SELECT id, nome FROM sts_situacoes ORDER BY nome ASC";
                                $resultado_sit = mysqli_query($conn, $result_sit);
                            ?>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="A situação da página ex: Ativa">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span>  Situação
                            </label>
                            <select name="sts_situacoe_id" id="sts_situacoe_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_sit = mysqli_fetch_assoc($resultado_sit)) {
                                        if (isset($_SESSION['dados']['sts_situacoe_id']) && ($_SESSION['dados']['sts_situacoe_id'] == $row_sit['id'])) {
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
                        <div class="form-group col-md-6">
                        <span class="text-danger">* </span><label>Foto </label>
                            <input name="imagem" type="file" id="imagem" onchange="previewImage()">
                        </div>
                        <div class="form-group col-md-6">
                            <img src="<?php echo pgsite.'/assets/imagens/paginas/default.png';?>" id="preview-user" class="img-thumbnail" style="width: 287px; heith: 150px;">
                        </div>
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadArtigo" id="SendCadArtigo"  type="submit" class="btn btn-success" value="Cadastrar"></input>
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
        <script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor1' ) )
                .catch( error => {
                    console.error( error );
                } );
            ClassicEditor
            .create( document.querySelector( '#editor2' ) )
            .catch( error => {
                console.error( error );
            } );
            ClassicEditor
            .create( document.querySelector( '#editor3' ) )
            .catch( error => {
                console.error( error );
            } );
            ClassicEditor
            .create( document.querySelector( '#editor4' ) )
            .catch( error => {
                console.error( error );
            } );
        </script>
    </div>
</body>
