<?php
if (!isset($seg)) {
    exit;
}

include_once 'app/adms/include/head.php';
?>
<body>    
    <?php
    include_once 'app/adms/include/header.php';
    ?>
    <div class="d-flex">
        <?php
        include_once 'app/adms/include/menu.php';
        ?>
        <div class="content p-1">
            <div class="list-group-item">
                <div class="d-flex">
                    <div class="mr-auto p-2">
                        <h2 class="display-4 titulo">Listar Usuário JS </h2>
                    </div>
                    <div class="p-2">
                        <?php
                        $btn_cad = carregarBtn('cadastrar/cad_usuario', $conn);
                        if ($btn_cad) {
                            echo "<a href='" . pg . "/cadastrar/cad_usuario' class='btn btn-outline-success btn-sm'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
                <span id="conteudo"></span>
            </div>
        </div>
        <?php
        include_once 'app/adms/include/rodape_lib.php';
        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script>
            var qnt_result_pg = 10;
            var pagina = 1;
            $(document).ready(function () {
                listar_usuario(pagina, qnt_result_pg);
                
            });
            function listar_usuario(pagina, qnt_result_pg){
               // $("#conteudo").html("");
                var dados = {
                    pagina: pagina, 
                    qnt_result_pg: qnt_result_pg
                }
                $.post('../app/cpadms/listar/list_usuario_js_assinc.php', dados, function(retorna) {
                    $("#conteudo").html(retorna);
                });
            }
        </script>

    </div>
</body>