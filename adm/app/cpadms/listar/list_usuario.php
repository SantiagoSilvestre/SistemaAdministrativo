<?php
if (!isset($seg)) {
    exit;
}
include_once 'app/adms/include/head.php';
?>
 <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
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
                            <h2 class="display-4 titulo">Listar Usuario</h2>
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
                    <hr>
                    <div class="table-responsive">
                        <table id="listar-usuario" class="table table-striped table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Nível de Acesso</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        <?php
            include_once 'app/adms/include/rodape_lib.php'
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="<?php echo pg."/app/cpadms/assets/js/jquery.dataTables.min.js" ?>"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#listar-usuario').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "../app/cpadms/listar/list_usuario_tables.php",
                        "type": "POST"
                    },
                });
            } );
        </script>
        </div>
    </body>
