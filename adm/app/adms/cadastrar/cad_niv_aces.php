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
                        <h2 class="display-4 titulo">Cadastrar Nível de Acesso</h2>
                    </div>
                    <div class="p-2">
                    <?php
                        $btn_list = carregarBtn("visualizar/vis_niv_aces",$conn);
                        if ($btn_list) {
                            ?>
                            <a class="btn btn-outline-info btn-sm" href="<?= pg."/listar/list_niv_aces" ?>"> Listar</a>
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
                <form method="POST" action="<?= pg; ?>/processa/proc_cad_niv_aces">
                    <div class="form-group">
                        <span class="text-danger">* </span>
                        <label>Nome:</label>
                        <input name="nome_niv_aces" type="text" class="form-control" id="nome_niv_aces" placeholder="Nome do nível de acesso">
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input name="SendCadNivAc" id="SendCadNivAc"  type="submit" class="btn btn-success" value="Cadastrar"></input>
                </form>
            </div>
        <?php           
            include_once 'app/adms/include/rodape_lib.php'
        ?>
    </div>
</body>
