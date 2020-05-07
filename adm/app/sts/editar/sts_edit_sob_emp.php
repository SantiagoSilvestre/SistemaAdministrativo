<?php 
    if(!isset($seg)){
        exit;
    }
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    if(!empty($id)) {
        $result_edit_sob_emp = "SELECT * FROM  sts_sobs_emps WHERE id = '".$id."' LIMIT 1";
        $resultado_edit_sob_emp = mysqli_query($conn, $result_edit_sob_emp);
        
        if(($resultado_edit_sob_emp) && ($resultado_edit_sob_emp->num_rows != 0) ){
            $row_edit_sob_emp = mysqli_fetch_assoc($resultado_edit_sob_emp);
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
                        <h2 class="display-4 titulo">Editar Sobre Empresa STS</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("listar/sts_list_sob_emp",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_sob_emp" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_sob_emp" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value='<?= $row_edit_sob_emp['id'] ?>'>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label> Título </label>
                            <input name="titulo" type="text" class="form-control" id="titulo" 
                            value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } else { echo $row_edit_sob_emp['titulo'];} ?>"
                            placeholder="Título ">
                        </div>
                        <div class="form-group col-md-6">
                            <?php
                                $result_sit = "SELECT id, nome FROM sts_situacoes ORDER BY nome ASC";
                                $resultado_sit = mysqli_query($conn, $result_sit);
                            ?>
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Define qual a situação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Situação
                            </label>
                            <select name="sts_situacoe_id" id="sts_situacoe_id" class="form-control">
                                <option value=""> Selecione</option>
                                <?php
                                    while($row_sit = mysqli_fetch_assoc($resultado_sit)) {
                                        if (isset($_SESSION['dados']['sts_situacoe_id']) && ($_SESSION['dados']['sts_situacoe_id'] == $row_sit['id'])) {
                                            echo "<option selected value='".$row_sit['id']."'>".$row_sit['nome']."</option>";
                                        } else if(!isset($_SESSION['dados']['sts_situacoe_id']) && ($row_edit_sob_emp['sts_situacoe_id'] ==$row_sit['id'] )) {
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
                        <div class="form-group col-md-12">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                    title="Coloque uma descrição no itém sobre empresa para melhor identificação">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                Descrição
                            </label>
                            <textarea name="descricao" type="text" class="form-control" id="descricao"><?php if(isset($_SESSION['dados']['descricao'])) { echo $_SESSION['dados']['descricao']; }else{ echo $row_edit_sob_emp['descricao'];}  ?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <input type="hidden" id="imagem_antiga" name="imagem_antiga" value="<?= $row_edit_sob_emp['imagem'] ?>">
                        <div class="form-group col-md-6">
                            <label>Foto </label>
                            <input name="imagem" type="file" id="imagem" onchange="previewImage()">
                        </div>
                        <?php
                            if (isset($row_edit_sob_emp['imagem'])) {
                                $imagem_antiga = pgsite . '/assets/imagens/sob_emp/'.$row_edit_sob_emp['id'].'/'.$row_edit_sob_emp['imagem'];
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
                    <input name="SendStsEdiSobEmp" id="SendStsEdiSobEmp"  type="submit" class="btn btn-warning" value="Salvar"></input>
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
        }else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
            $url_destino = pg.'/listar/sts_list_sob_emp';
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
        $url_destino = pg.'/acesso/login';
        header("Location: $url_destino");
    }