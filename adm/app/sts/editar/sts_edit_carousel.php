<?php 
    if(!isset($seg)){
        exit;
    }
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(!empty($id)) {
        $result_edit_carousel = "SELECT * FROM  sts_carousels WHERE id = '".$id."' LIMIT 1";
        $resultado_edit_carousel = mysqli_query($conn, $result_edit_carousel);
        
        if(($resultado_edit_carousel) && ($resultado_edit_carousel->num_rows != 0) ){
            $row_edit_carousel = mysqli_fetch_assoc($resultado_edit_carousel);
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
                        <h2 class="display-4 titulo">Editar Carousel STS</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("listar/sts_list_carousels",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_carousels" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_carousel" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="<?= $row_edit_carousel['id'] ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                title="Nome do Carousel, auto-explicativo">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Nome
                            </label>
                            <input name="nome" type="text" class="form-control" id="nome" 
                            value="<?php if(isset($_SESSION['dados']['nome'])) { echo $_SESSION['dados']['nome']; } else { echo $row_edit_carousel['nome'];} ?>"
                            placeholder="Nome do Carousel">
                        </div>
                        <div class="form-group col-md-6">
                            <label> Título </label>
                            <input name="titulo" type="text" class="form-control" id="titulo" 
                            value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } else { echo $row_edit_carousel['titulo'];} ?>"
                            placeholder="Título do carousel">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no carousel para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Descrição
                            </label>
                            <input name="descricao" type="text" class="form-control" id="descricao" 
                            value="<?php if(isset($_SESSION['dados'])) { echo $_SESSION['dados']['descricao']; } else { echo $row_edit_carousel['descricao'];} ?>"
                            placeholder="Descrição do Carousel">
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Escolha em qual lugar o texto será apresentado">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                posicao do Texto
                            </label>
                            <select name="posicao_text" id="posicao_text" class="form-control">
                                <?php
                                    if (isset($_SESSION['dados']['posicao_text']) && ($_SESSION['dados']['posicao_text'] == 'text-left') || ($row_edit_carousel['posicao_text'] == 'text-left') ) {
                                        echo "<option value=''> Selecione</option>";
                                        echo "<option selected value='text-left'>Esquerda</option>";
                                        echo "<option value='text-center'>Centro</option>";
                                        echo "<option value='text-right'>Direita</option>";
                                    } else if(isset($_SESSION['dados']['posicao_text']) && ($_SESSION['dados']['posicao_text'] == 'text-center') || ($row_edit_carousel['posicao_text'] == 'text-center')) {
                                        echo "<option value='' selected> Selecione</option>";
                                        echo "<option value='text-left'>Esquerda</option>";
                                        echo "<option selected value='text-center'>Centro</option>";
                                        echo "<option value='text-right'>Direita</option>";
                                    }  else if(isset($_SESSION['dados']['posicao_text']) && ($_SESSION['dados']['posicao_text'] == 'text-right') || ($row_edit_carousel['posicao_text'] == 'text-right')) {
                                        echo "<option value='' selected> Selecione</option>";
                                        echo "<option value='text-left'>Esquerda</option>";
                                        echo "<option value='text-center'>Centro</option>";
                                        echo "<option selected value='text-right'>Direita</option>";
                                    } else {
                                        echo "<option value='' selected> Selecione</option>";
                                        echo "<option value='text-left'>Esquerda</option>";
                                        echo "<option value='text-center'>Centro</option>";
                                        echo "<option value='text-right'>Direita</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque um título para o botão">
                                    <i class="fas fa-question-circle"></i>
                                </span> Título do Botão
                            </label>
                            <input name="titulo_botao" type="text" class="form-control" id="titulo_botao" 
                            value="<?php if(isset($_SESSION['dados']['titulo_botao'])) { echo $_SESSION['dados']['titulo_botao']; } else { echo $row_edit_carousel['titulo_botao'];} ?>"
                            placeholder="Botão Que aparecerá no Carousel">
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Para onde vai ser redirecionado">
                                    <i class="fas fa-question-circle"></i>
                                </span> Link
                            </label>
                            <input name="link" type="text" class="form-control" id="link" 
                            value="<?php if(isset($_SESSION['dados']['link'])) { echo $_SESSION['dados']['link']; } else { echo $row_edit_carousel['link'];} ?>"
                            placeholder="Botão Que aparecerá no Carousel">
                        </div>
                    </div>
                    <div class="form-row">
                    <div class="form-group col-md-6">
                            <?php
                                $result_cors = "SELECT id, nome FROM sts_cors ORDER BY nome ASC";
                                $resultado_cors = mysqli_query($conn, $result_cors);
                            ?>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Define qual é cor">
                                    <i class="fas fa-question-circle"></i>
                                </span> Cor Carousel ?
                            </label>
                            <select name="sts_cor_id" id="sts_cor_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_cors = mysqli_fetch_assoc($resultado_cors)) {
                                        if (isset($_SESSION['dados']['sts_cor_id']) && ($_SESSION['dados']['sts_cor_id'] == $row_cors['id'])) {
                                            echo "<option selected value='".$row_cors['id']."'>".$row_cors['nome']."</option>";
                                        } else if( (!isset($_SESSION['dados']['sts_cor_id'])) && ($row_edit_carousel['sts_cor_id'] == $row_cors['id'])) {
                                            echo "<option selected value='".$row_cors['id']."'>".$row_cors['nome']."</option>";
                                        }else {
                                            echo "<option value='".$row_cors['id']."'>".$row_cors['nome']."</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <?php
                                $result_sit = "SELECT id, nome FROM sts_situacoes ORDER BY nome ASC";
                                $resultado_sit = mysqli_query($conn, $result_sit);
                            ?>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Define qual a situação do carousel">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Situação do Carousel
                            </label>
                            <select name="sts_situacoe_id" id="sts_situacoe_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_sit = mysqli_fetch_assoc($resultado_sit)) {
                                        if (isset($_SESSION['dados']['sts_situacoe_id']) && ($_SESSION['dados']['sts_situacoe_id'] == $row_sit['id'])) {
                                            echo "<option selected value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                        } else if( (!isset($_SESSION['dados']['sts_situacoe_id'])) && ($row_edit_carousel['sts_situacoe_id'] == $row_sit['id'])) {
                                            echo "<option selected value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                        } else {
                                            echo "<option value='".$row_sit['id']."'>". $row_sit['nome']. "</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <input type="hidden" name="imagem_antiga" value="<?php echo $row_edit_carousel['imagem']; ?>">
                        <div class="form-group col-md-6">
                            <label>Foto </label>
                            <input name="imagem" type="file" id="imagem" onchange="previewImage()">
                        </div>
                            <?php
                                if (isset($row_edit_carousel['imagem'])) {
                                    $imagem_antiga = pgsite . '/assets/imagens/carousel/'.$row_edit_carousel['id'].'/'.$row_edit_carousel['imagem'];
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
                    <input name="SendStsEditCarousel" id="SendStsEditCarousel"  type="submit" class="btn btn-warning" value="Salvar"></input>
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