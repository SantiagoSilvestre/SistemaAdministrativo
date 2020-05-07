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
                        <h2 class="display-4 titulo">Cadastrar Pergunta e Resposta</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("listar/sts_list_perg_resp",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/sts_list_perg_resp" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_sts_cad_per_resp">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" 
                                title="Pergunta, auto-explicativo">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="text-danger">*</span> Pergunta
                            </label>
                            <input name="pergunta" type="text" class="form-control" id="pergunta" 
                            value="<?php if(isset($_SESSION['dados']['pergunta'])) { echo $_SESSION['dados']['pergunta']; } ?>"
                            placeholder="Digite a pergunta">
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
                                Resposta
                            </label>
                            <textarea name="resposta" class="form-control" id="resposta"><?php if(isset($_SESSION['dados']['resposta'])) { echo $_SESSION['dados']['resposta']; } ?></textarea>
                        </div>
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendStsCadPerResp" id="SendStsCadPerResp"  type="submit" class="btn btn-success" value="Cadastrar"></input>
                </form>
            </div>
        <?php  
            unset($_SESSION['dados']);         
            include_once 'app/adms/include/rodape_lib.php'
        ?>
    </div>
</body>
