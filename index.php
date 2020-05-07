<?php
session_start();
ob_start();

$seguranca = true;

//Biblioteca auxiliares
include_once 'config/config.php';
include_once 'config/conexao.php';
include_once 'lib/lib_valida.php';

$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_STRING);

$url_limpa = limparurl($url);
$endereco = explode('/', $url_limpa);



$result_pagina = "SELECT pag.*,
        rob.tipo,
        tp.tipo as tipo_tpg
        FROM sts_paginas pag
        INNER JOIN sts_robots rob ON rob.id=pag.sts_robot_id
        INNER JOIN sts_tps_pgs tp ON pag.sts_tps_pgs_id = tp.id
        WHERE pag.endereco='".$endereco[0]."' AND pag.sts_situacaos_pg_id=1 LIMIT 1";
$resultado_pagina = mysqli_query($conn, $result_pagina);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <?php
    if(($resultado_pagina) AND ($resultado_pagina->num_rows != 0)){
        $row_pagina = mysqli_fetch_assoc($resultado_pagina);
        $file = 'app/'.$row_pagina['tipo_tpg'].'/'.$endereco[0].'.php';
        if(file_exists($file)){
            include $file;
        }else{
            $url_destino = pg."/home";
            header("Location: $url_destino");
        }
    }else{        
        $url_destino = pg . "/home";
        header("Location: $url_destino");
    }
    ?>
</html>
