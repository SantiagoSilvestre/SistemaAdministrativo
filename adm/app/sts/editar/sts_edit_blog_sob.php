<?php 
    if(!isset($seg)){
        exit;
    }
    $result_blog = "SELECT * FROM sts_blogs_sobres LIMIT 1";
    
    $resultado_blog = mysqli_query($conn, $result_blog);

    if(($resultado_blog) && ($resultado_blog->num_rows != 0) ){
        $row_blog = mysqli_fetch_assoc($resultado_blog);
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
                                <h2 class="display-4 titulo">Editar Blog Sobre</h2>
                            </div>
                        </div>
                        <hr>
                        <?php
                            if(isset($_SESSION['msg'])) {
                                echo $_SESSION['msg'];
                                unset($_SESSION['msg']);
                            }
                        ?>
                        <form method="POST" action="<?= pg; ?>/processa/proc_sts_edit_blog">
                            <input type="hidden" id="id" name="id" value="<?= $row_blog['id'] ?>">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>
                                        <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                        title="titulo, auto-explicativo">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                        <span class="text-danger">*</span> titulo
                                    </label>
                                    <input name="titulo" type="text" class="form-control" id="titulo" 
                                    value="<?php if(isset($_SESSION['dados']['titulo'])) { echo $_SESSION['dados']['titulo']; } else { echo $row_blog['titulo'];} ?>"
                                    placeholder="Digite a titulo">
                                </div>
                                <div class="form-group col-md-6">
                                    <?php
                                        $result_sit_per = "SELECT id, nome FROM sts_situacoes ORDER BY nome ASC";
                                        $resultado_sit_per = mysqli_query($conn, $result_sit_per);
                                    ?>
                                    <label>
                                        <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                            title="Define qual se a pergunta vai aparecer no site ou não">
                                            <i class="fas fa-question-circle"></i>
                                        </span> Situação
                                    </label>
                                    <select name="sts_situacoe_id" id="sts_situacoe_id" class="form-control">
                                        <option value=""> Selecione</option>
                                        <?php
                                            while($row_sit_per = mysqli_fetch_assoc($resultado_sit_per)) {
                                                if (isset($_SESSION['dados']['sts_situacoe_id']) && ($_SESSION['dados']['sts_situacoe_id'] == $row_sit_per['id'])) {
                                                    echo "<option selected value='".$row_sit_per['id']."'>".$row_sit_per['nome']."</option>";
                                                } else if ( !(isset($_SESSION['dados']['sts_situacoe_id'])) && ($row_sit_per['id'] == $row_blog['sts_situacoe_id'])) {
                                                    echo "<option selected value='".$row_sit_per['id']."'>".$row_sit_per['nome']."</option>";
                                                } else {
                                                    echo "<option value='".$row_sit_per['id']."'>".$row_sit_per['nome']."</option>";
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
                                            title="Coloque a resposta para sua perguta">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                        descricao
                                    </label>
                                    <textarea name="descricao" class="form-control" id="descricao"><?php if(isset($_SESSION['dados']['descricao'])) { echo $_SESSION['dados']['descricao']; } else { echo $row_blog['descricao'];} ?></textarea>
                                </div>
                            </div>
                            <p>
                                <span class="text-danger">* </span>Campo obrigatório
                            </p>
                            <input name="SendStsEditBlog" id="SendStsEditBlog"  type="submit" class="btn btn-warning" value="Salvar"></input>
                        </form>
                    </div>
                <?php          
                    include_once 'app/adms/include/rodape_lib.php'
                ?>
            </div>
        </body>
        <?php
        unset($_SESSION['dados']);
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
        $url_destino = pg.'/listar/sts_edit_blog_sob';
        header("Location: $url_destino");
    }
    
?>