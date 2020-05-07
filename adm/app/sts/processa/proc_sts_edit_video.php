<?php
if (!isset($seg)) {
    exit;
}
$SendStsEditvideo = filter_input(INPUT_POST, 'SendStsEditvideo', FILTER_SANITIZE_STRING);

if($SendStsEditvideo) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    $erro = false;

    foreach($dados as $d ){
        echo $d;
        if(empty($d)){
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os para Editar</div>";
        }
    }
 
    if($erro) {
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/editar/sts_edit_video';
        header("Location: $url_destino");
    } else {
        $result_edit_video = "UPDATE sts_videos SET
                titulo = '".$dados['titulo']."',
                descricao = '".$dados['descricao']."',
                video_um = '".$dados['video_um']."',
                video_dois = '".$dados['video_dois']."',
                video_tres = '".$dados['video_tres']."',
                modified = NOW()
                WHERE id = '".$dados['id']."' ";
       mysqli_query($conn, $result_edit_video);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);

            $_SESSION['msg'] = "<div class='alert alert-success'>página de serviços Editada com sucesso</div>";
            $url_destino = pg.'/editar/sts_edit_video';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>  Erro ao editar a página</div>";
            $url_destino = pg.'/processa/proc_sts_edit_video';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
