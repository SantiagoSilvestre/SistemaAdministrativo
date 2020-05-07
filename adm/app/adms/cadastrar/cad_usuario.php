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
                        <h2 class="display-4 titulo">Cadastrar Usuário</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("listar/list_usuario",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/list_usuario" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_cad_usuario" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                title="Nome do usuário">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Nome
                            </label>
                            <input name="nome" type="text" class="form-control" id="nome" 
                            value="<?php if(isset($_SESSION['dados']['nome'])) { echo $_SESSION['dados']['nome']; } ?>"
                            placeholder="Nome do Usuário completo">
                        </div>
                        <div class="form-group col-md-6">
                            <label><span class="text-danger">*</span> E-mail</label>
                            <input name="email" type="email" class="form-control" id="email" 
                            value="<?php if(isset($_SESSION['dados']['email'])) { echo $_SESSION['dados']['email']; } ?>"
                            placeholder="Seu melhor e-mail">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label><span class="text-danger">*</span> Usuário </label>
                            <input name="usuario" type="text" class="form-control" id="usuario" 
                            value="<?php if(isset($_SESSION['dados']['usuario'])) { echo $_SESSION['dados']['usuario']; } ?>"
                            placeholder="Nome do usuário para login">
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">*</span> Senha</label>
                            <input name="senha" type="password" class="form-control" id="senha" 
                            value="<?php if(isset($_SESSION['dados']['senha'])) { echo $_SESSION['dados']['senha']; } ?>"
                            placeholder="Senha deve ter 6 caracteres">
                        </div>
                        <div class="form-group col-md-3">
                            <label> Apelido </label>
                            <input name="apelido" type="text" class="form-control" id="apelido" 
                            value="<?php if(isset($_SESSION['dados']['apelido'])) { echo $_SESSION['dados']['apelido']; } ?>"
                            placeholder="Apelido do usuário">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <?php
                                $result_nivac = "SELECT id, nome FROM adms_niveis_acesso ORDER BY nome ASC";
                                $resultado_nivac = mysqli_query($conn, $result_nivac);
                            ?>
                            <label><span class="text-danger">*</span>  Nível de acesso </label>
                            <select name="adms_niveis_acesso_id" id="adms_niveis_acesso_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_nivac = mysqli_fetch_assoc($resultado_nivac)) {
                                        if (isset($_SESSION['dados']['adms_niveis_acesso_id']) && ($_SESSION['dados']['adms_niveis_acesso_id'] == $row_nivac['id'])) {
                                            echo "<option selected value='".$row_nivac['id']."'>".$row_nivac['nome']."</option>";
                                        } else {
                                            echo "<option value='".$row_nivac['id']."'>".$row_nivac['nome']."</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <?php
                                $result_sit_user = "SELECT id, nome FROM adms_sits_usuarios ORDER BY nome ASC";
                                $resultado_sit_user = mysqli_query($conn, $result_sit_user);
                            ?>
                            <label><span class="text-danger">*</span>  Situação do usuário </label>
                            <select name="adms_sits_usuario_id" id="adms_sits_usuario_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_sit_user = mysqli_fetch_assoc($resultado_sit_user)) {
                                        if (isset($_SESSION['dados']['adms_sits_usuario_id']) && ($_SESSION['dados']['adms_sits_usuario_id'] == $row_sit_user['id'])) {
                                            echo "<option selected value='".$row_sit_user['id']."'>".$row_sit_user['nome']."</option>";
                                        } else {
                                            echo "<option value='".$row_sit_user['id']."'>".$row_sit_user['nome']."</option>";
                                        }
                                    }

                                ?> 
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Foto </label>
                            <input name="imagem" type="file" id="imagem" onchange="previewImage()">
                        </div>
                        <div class="form-group col-md-6">
                            <img src="<?php echo pg.'/assets/imagens/preview.png';?>" id="preview-user" class="img-thumbnail" style="width: 150px; heith: 15px;">
                        </div>
                    </div>
                    
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadUser" id="SendCadUser"  type="submit" class="btn btn-success" value="Cadastrar"></input>
                </form>
            </div>
        <?php  
            unset($_SESSION['dados']);         
            include_once 'app/adms/include/rodape_lib.php';
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
