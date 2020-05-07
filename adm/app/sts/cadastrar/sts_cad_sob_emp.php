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
                        <h2 class="display-4 titulo">Cadastrar Sobre Empresa STS</h2>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_sts_cad_sob_emp" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label> Título </label>
                            <input name="titulo" type="text" class="form-control" id="titulo" 
                            value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } ?>"
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
                            <textarea name="descricao" type="text" class="form-control" id="descricao"><?php if(isset($_SESSION['dados'])) { echo $_SESSION['dados']['descricao']; } ?></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Foto </label>
                            <input name="imagem" type="file" id="imagem" onchange="previewImage()">
                        </div>
                        <div class="form-group col-md-6">
                            <img src="<?php echo pgsite.'/assets/imagens/paginas/default.png';?>" id="preview-user" class="img-thumbnail" style="width: 287px; heith: 150px;">
                        </div>
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendStsCadSobEmp" id="SendStsCadSobEmp"  type="submit" class="btn btn-success" value="Cadastrar"></input>
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
