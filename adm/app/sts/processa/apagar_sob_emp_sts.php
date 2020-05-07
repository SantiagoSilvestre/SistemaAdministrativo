<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $result_sob_ver = "SELECT id, ordem as ordem_result FROM  sts_sobs_emps WHERE ordem > 
                        (SELECT ordem FROM  sts_sobs_emps WHERE id='".$id."') ORDER BY ordem ASC";

    $resultado_sob_ver = mysqli_query($conn, $result_sob_ver);
    
    $result_car_foto = "SELECT id, imagem FROM sts_sobs_emps WHERE id='".$id."' LIMIT 1";
    $resultado_car_foto = mysqli_query($conn, $result_car_foto);
    $row = mysqli_fetch_assoc($resultado_car_foto);
    if(!empty($row['imagem']) ) { 
        include_once 'lib/lib_upload.php';                
        $destino = "../assets/imagens/sob_emp/" . $row['id'] . "/";
        $destino_apagar = $destino.$row['imagem'];
        apagarFoto($destino_apagar);
        apagarDiretorio($destino);
    }

    $result_car_del = "DELETE FROM sts_sobs_emps WHERE id ='".$id."' ";
    $resultado_car_del = mysqli_query($conn, $result_car_del);

    if(mysqli_affected_rows($conn)) {

        while($row_sob_ver = mysqli_fetch_assoc($resultado_sob_ver)) {
            $row_sob_ver['ordem_result'] = $row_sob_ver['ordem_result'] - 1;
            $result_car_or = "UPDATE sts_sobs_emps 
                                SET ordem = '".$row_sob_ver['ordem_result']."',
                                modified = NOW()
                                WHERE id = '".$row_sob_ver['id']."'";
            mysqli_query($conn, $result_car_or);
        }

        //Apagar as permissões de acesso a página na tabela adms_nivac
        $_SESSION['msg'] = "<div class='alert alert-success'> Sobre empresa STS apagada com sucesso! </div>";
        $url_destino = pg . '/listar/sts_list_sob_emp';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Erro o Sobre empresa STS não foi apagado! </div>";
        $url_destino = pg . '/listar/sts_list_sob_emp';
        header("Location: $url_destino");
    }
    
        
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

