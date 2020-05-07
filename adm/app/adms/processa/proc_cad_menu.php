<?php
if (!isset($seg)) {
    exit;
}
$sendCadMenu = filter_input(INPUT_POST, 'SendCadMenu', FILTER_SANITIZE_STRING);

if($sendCadMenu) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $erro = false ;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos para Cadastro <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button></div>";
    }

    if($erro) {
        $url_destino = pg.'/cadastrar/cad_menu';
        header("Location: $url_destino");
    } else {
        $result_maior_ordem = "SELECT ordem FROM adms_menu ORDER BY ordem DESC LIMIT 1";
        $resultado_maior_ordem = mysqli_query($conn, $result_maior_ordem);
        $row_maior_ordem = mysqli_fetch_assoc($resultado_maior_ordem);
        $ordem = $row_maior_ordem['ordem'] + 1;
        $result_cad_menu = "INSERT INTO adms_menu (nome, icone, ordem, adms_sit_id, created) 
                        VALUES ('".$dados_validos['nome']."', 
                                 '".$dados_validos['icone']."',
                                 '".$ordem."',
                                 '".$dados_validos['adms_sit_id']."',
                                  NOW() ) "; 
        mysqli_query($conn, $result_cad_menu);
        
        if(mysqli_insert_id($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'> Inserido com sucesso!<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button></div>";
            $url_destino = pg.'/listar/list_menu';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> Erro ao inserir o Menu<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
        </button></div>";
            $url_destino = pg.'/cadastrar/cad_menu';
            header("Location: $url_destino");
        }
    }


} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
