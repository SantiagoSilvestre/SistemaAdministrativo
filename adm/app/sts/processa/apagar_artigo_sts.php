<?php
if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!empty($id)) {

    $result_car_foto = "SELECT id, imagem FROM sts_artigos WHERE id='".$id."' LIMIT 1";
    $resultado_car_foto = mysqli_query($conn, $result_car_foto);
    $row = mysqli_fetch_assoc($resultado_car_foto);
    if(!empty($row['imagem']) ) { 
        include_once 'lib/lib_upload.php';                
        $destino = "../assets/imagens/artigo/" . $row['id'] . "/";
        $destino_apagar = $destino.$row['imagem'];
        apagarFoto($destino_apagar);
        apagarDiretorio($destino);
    }

    $result_car_del = "DELETE FROM sts_artigos WHERE id ='".$id."' ";
    $resultado_car_del = mysqli_query($conn, $result_car_del);

    if(mysqli_affected_rows($conn)) {

        //Apagar as permissões de acesso a página na tabela adms_nivac
        $_SESSION['msg'] = "<div class='alert alert-success'> Artigo STS apagada com sucesso! </div>";
        $url_destino = pg . '/listar/sts_list_artigos';
        header("Location: $url_destino");
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'> Erro o Artigo STS não foi apagado! </div>";
        $url_destino = pg . '/listar/sts_list_artigos';
        header("Location: $url_destino");
    }
    
        
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada! </div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}

