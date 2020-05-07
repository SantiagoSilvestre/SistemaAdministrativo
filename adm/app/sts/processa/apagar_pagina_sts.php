<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {
    $result_pg_depend = "SELECT id, depend_pg, imagem FROM sts_paginas WHERE id = '".$id."' LIMIT 1";
    $resultado_pg_depend = mysqli_query($conn, $result_pg_depend);

    $result_men_ver = "SELECT id, ordem as ordem_result FROM sts_paginas WHERE ordem > 
                        (SELECT ordem FROM sts_paginas WHERE id='".$id."') ORDER BY ordem ASC";

    $resultado_men_ver = mysqli_query($conn, $result_men_ver);


    if (($resultado_pg_depend) && ($resultado_pg_depend->num_rows != 0 )){
        $row = mysqli_fetch_assoc($resultado_pg_depend);
        
        if ($row['depend_pg'] == 0 ) {
            $result_pg_dp = "SELECT id, nome_pagina, imagem FROM sts_paginas WHERE depend_pg = '".$id."' LIMIT 1";
            $resultado_pg_dp = mysqli_query($conn, $result_pg_dp);
            if (($resultado_pg_dp) && ($resultado_pg_dp->num_rows != 0 )){
                $_SESSION['msg'] = "<div class='alert alert-danger'> Não é possível apagar essa página porque existe uma página dependente </div>";
                $url_destino = pg . '/listar/sts_list_pagina';
                header("Location: $url_destino");
            } else {
                if(!empty($row['imagem']) ) {
                    echo "tem foto";    
                    include_once 'lib/lib_upload.php';                
                    $destino = "../assets/imagens/paginas/" . $row['id'] . "/";
                    $destino_apagar = $destino.$row['imagem'];
                    apagarFoto($destino_apagar);
                    apagarDiretorio($destino);
                }
                $result_pg_del = "DELETE FROM sts_paginas WHERE id ='".$id."' ";
                $resultado_pg_del = mysqli_query($conn, $result_pg_del);
            
                if(mysqli_affected_rows($conn)) {

                    while($row_men_ver = mysqli_fetch_assoc($resultado_men_ver)) {
                        $row_men_ver['ordem_result'] = $row_men_ver['ordem_result'] - 1;
                        $result_men_or = "UPDATE sts_paginas 
                                          SET ordem = '".$row_men_ver['ordem_result']."',
                                          modified = NOW()
                                          WHERE id = '".$row_men_ver['id']."'";
                        mysqli_query($conn, $result_men_or);
                    }
            
                    //Apaagar as permissões de acesso a página na tabela adms_nivac
                    $_SESSION['msg'] = "<div class='alert alert-success'> Página STS apagada com sucesso! </div>";
                    $url_destino = pg . '/listar/sts_list_pagina';
                    header("Location: $url_destino");
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-danger'> Erro a página STS não foi apagada! </div>";
                    $url_destino = pg . '/listar/sts_list_pagina';
                    header("Location: $url_destino");
                }
            }
        } else {
            
            if(!empty($row['imagem']) ) {
                include_once 'lib/lib_upload.php';                
                $destino = "../assets/imagens/paginas/" . $row['id'] . "/";
                $destino_apagar = $destino.$row['imagem'];
                apagarFoto($destino_apagar);
                apagarDiretorio($destino);
            }
            $result_pg_del = "DELETE FROM sts_paginas WHERE id ='".$id."' ";
            $resultado_pg_del = mysqli_query($conn, $result_pg_del);
        
            if(mysqli_affected_rows($conn)) {

                while($row_men_ver = mysqli_fetch_assoc($resultado_men_ver)) {
                    $row_men_ver['ordem_result'] = $row_men_ver['ordem_result'] - 1;
                    $result_men_or = "UPDATE sts_paginas 
                                      SET ordem = '".$row_men_ver['ordem_result']."',
                                      modified = NOW()
                                      WHERE id = '".$row_men_ver['id']."'";
                    mysqli_query($conn, $result_men_or);
                }
        
                //Apagar as permissões de acesso a página na tabela adms_nivac
                $_SESSION['msg'] = "<div class='alert alert-success'> Página STS apagada com sucesso! </div>";
                $url_destino = pg . '/listar/sts_list_pagina';
                header("Location: $url_destino");
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'> Erro a página STS não foi apagada! </div>";
                $url_destino = pg . '/listar/sts_list_pagina';
                header("Location: $url_destino");
            }        
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
        $url_destino = pg . '/acesso/login';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

