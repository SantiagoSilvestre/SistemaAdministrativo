<?php

if (!isset($seg)) {
    exit;
}
$SendEditPer = filter_input(INPUT_POST, 'SendEditPer', FILTER_SANITIZE_STRING);
if ($SendEditPer) {
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    //Retirar campo da validação vazio
    $dados_icone = $dados['icone'];  
    unset($dados['icone']);
    
    //validar nenhum campo vazio
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if (!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos com <b>*</b> para editar permissão!</div>";
    }
    
    //Houve erro em algum campo será redirecionado para o login, não há erro no formulário tenta cadastrar no banco
    if ($erro) {
        $url_destino = pg . '/editar/edit_permissao?id=' . $dados['id'];
        header("Location: $url_destino");
    }else{
        //Alterar o menu
        $result_nivpg_up = "UPDATE adms_nivacs_pgs SET
                adms_menu_id='" . $dados_validos['adms_menu_id'] . "', 
                modified=NOW() 
                WHERE id='" . $dados_validos['id'] . "'";
        mysqli_query($conn, $result_nivpg_up);
        
        if (mysqli_affected_rows($conn)) {
            //Pesquisar o ID da página e do nível de acesso
            $result_nivpg = "SELECT adms_niveis_acesso_id, adms_paginas_id FROM adms_nivacs_pgs WHERE id='" . $dados_validos['id'] . "' LIMIT 1";
            $resultado_nivpg = mysqli_query($conn, $result_nivpg);
            
            if (($resultado_nivpg) AND ( $resultado_nivpg->num_rows != 0)) {
                $row_nivpg = mysqli_fetch_assoc($resultado_nivpg);
                
                //Alterar o icone
                $result_pg_up = "UPDATE adms_paginas SET
                    icone='" . $dados_icone . "', 
                    modified=NOW() 
                    WHERE id='" . $row_nivpg['adms_paginas_id'] . "'";
                mysqli_query($conn, $result_pg_up);
                if (mysqli_affected_rows($conn)) {
                    $_SESSION['msg'] = "<div class='alert alert-success'>Ícone editado com sucesso! <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    $url_destino = pg . '/listar/list_permissao?id='.$row_nivpg['adms_niveis_acesso_id'];
                    header("Location: $url_destino");
                }else{
                    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao editar a permissão. Erro no campo ícone!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    $url_destino = pg . '/editar/edit_permissao?id=' . $dados['id'];
                    header("Location: $url_destino");
                }                
            }else{
                $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao editar a permissão. Erro no campo ícone!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                $url_destino = pg . '/editar/edit_permissao?id=' . $dados['id'];
                header("Location: $url_destino");
            }            
        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao editar a permissão. Erro no campo menu!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            $url_destino = pg . '/editar/edit_permissao?id=' . $dados['id'];
            header("Location: $url_destino");
        }
    }    
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/acesso/login';
    header("Location: $url_destino");
}