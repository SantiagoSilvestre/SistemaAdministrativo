<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
    include_once 'app/adms/include/head.php';
   
    
    $result_edit_video = "SELECT * FROM  sts_videos LIMIT 1";
    $resultado_edit_video = mysqli_query($conn, $result_edit_video);
    
    if(($resultado_edit_video) && ($resultado_edit_video->num_rows != 0) ){
        $row_edit_video = mysqli_fetch_assoc($resultado_edit_video);
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
                        <h2 class="display-4 titulo">Editar Vídeo STS</h2>
                    </div>
                </div>
                <hr>
                <?php
                    if(isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_video">
                    <input type="hidden" id="id" name="id" value="<?= $row_edit_video['id'] ?>">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                title="Nome do video, auto-explicativo">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Titulo
                            </label>
                            <input name="titulo" type="text" class="form-control" id="titulo" 
                            value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } else { echo $row_edit_video['titulo'];} ?>"
                            placeholder="Título dos serviços">
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no video para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Descrição
                            </label>
                            <input name="descricao" type="text" class="form-control" id="descricao" 
                            value="<?php if(isset($_SESSION['dados']['descricao'])) { echo $_SESSION['dados']['descricao']; } else { echo $row_edit_video['descricao'];} ?>"
                            placeholder="Descrição dos vídeos">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque o link de compartilhamento do vídeo do youtube">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Vídeo um
                            </label>
                            <input name="video_um" type="text" class="form-control" id="video_um" 
                            value='<?php if(isset($_SESSION['dados']['video_um'])) { echo $_SESSION['dados']['video_um']; } else { echo $row_edit_video['video_um'];} ?>'
                            placeholder="Vídeo um">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque o link de compartilhamento do vídeo do youtube">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Vídeo dois
                            </label>
                            <input name="video_dois" type="text" class="form-control" id="video_dois";
                            value='<?php if(isset($_SESSION['dados']['video_dois'])) { echo $_SESSION['dados']['video_dois']; } else { echo $row_edit_video['video_dois'];} ?>'
                            placeholder="Descrição do Serviço">
                        </div>
                        <div class="form-group col-md-4">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque o link de compartilhamento do vídeo do youtube">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Vídeo três
                            </label>
                            <input name="video_tres" type="text" class="form-control" id="video_tres" 
                            value='<?php if(isset($_SESSION['dados']['video_tres'])) { echo $_SESSION['dados']['video_tres']; } else { echo $row_edit_video['video_tres'];} ?>'
                            placeholder="icone ex: fa fas-edit">
                        </div>
                    </div>
                    
                    
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendStsEditvideo" id="SendStsEditvideo"  type="submit" class="btn btn-warning" value="Salvar"></input>
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
   