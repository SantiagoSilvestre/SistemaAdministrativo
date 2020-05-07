<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';

        $result_user = "SELECT u.*, s.nome as nome_sit, c.cor as nome_cor, niv_ac.nome as nome_niv_ac
        FROM adms_usuarios u
        INNER JOIN adms_sits_usuarios s ON u.adms_sits_usuario_id = s.id
        INNER JOIN adms_cors c ON s.adms_cor_id = c.id
        INNER JOIN adms_niveis_acesso niv_ac on niv_ac.id=u.adms_niveis_acesso_id
        WHERE u.id = '".$_SESSION['id']."' LIMIT 1"; 
        
        $resultado_user = mysqli_query($conn, $result_user);
        if (($resultado_user) && ($resultado_user->num_rows != 0 )) {
            $row_user = mysqli_fetch_assoc($resultado_user);
?>
        <body>
            <?php  include_once 'app/adms/include/header.php'; ?>
            <div class="d-flex">
                <?php 
                    include 'app/adms/include/menu.php';            
                ?>
                <div class="content p-1">
                    <div class="list-group-item">
                        <div class="d-flex">
                            <div class="mr-auto p-2">
                                <h2 class="display-4 titulo">Perfil</h2>
                            </div>
                            <div class="p-2">
                                <span class="d-none d-md-block">
                                    <?php
                                        $btn_edit = carregarBtn("editar/edit_perfil",$conn);
                                        if ($btn_edit) {
                                            ?>
                                            <a class="btn btn-outline-warning btn-sm" href="<?= pg."/editar/edit_perfil"; ?>">Editar</a>
                                            <?php
                                        }
                                    ?> 
                                </span>
                            </div>  
                            
                        </div>
                        <hr>
                        <?php

                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                                                ?>
                        <dl class="row">

                            <dt class="col-sm-3">Imagem</dt>
                            <dd class="col-sm-9">
                                <?php 
                                    if (!empty($row_user['imagem'])) {
                                        echo "<img src='".pg."/assets/imagens/usuario/".$row_user['id']."/".$row_user['imagem']."' width='150' height='150'>";
                                    }                                     
                                ?>
                            </dd>

                            <dt class="col-sm-3">ID</dt>
                            <dd class="col-sm-9"><?= $row_user['id'] ?></dd>

                            <dt class="col-sm-3">Nome</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['nome']?></dd>

                            <dt class="col-sm-3">Apelido</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['apelido']?></dd>

                            <dt class="col-sm-3">E-mail</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['email']?></dd>

                            <dt class="col-sm-3">Usuário</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['usuario']?></dd>

                            <dt class="col-sm-3">Nível de Acesso</dt>
                            <dd class="col-sm-9"> <?php echo $row_user['nome_niv_ac']?></dd>

                            

                        </dl>                        
                    </div>
                </div>
                <?php           
                    include_once 'app/adms/include/rodape_lib.php'
                ?>
            </div>
        </body>
    <?php
        }else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Usuário não encontrado!</div>";
            $url_destino = pg.'/listar/list_usuario';
            header("Location: $url_destino");
        }
