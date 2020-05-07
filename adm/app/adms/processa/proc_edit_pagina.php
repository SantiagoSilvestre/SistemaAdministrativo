<?php
if (!isset($seg)) {
    exit;
}
$sendEditPg = filter_input(INPUT_POST, 'SendEditPg', FILTER_SANITIZE_STRING);

if($sendEditPg) {

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    $dados_obs = $dados['obs'];
    $dados_icone = $dados['icone'];
    unset($dados['obs'], $dados['icone']);
    //validar campos vazios
    $erro = false;
    include_once 'lib/lib_vazio.php';
    $dados_validos = vazio($dados);
    if(!$dados_validos) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os para Editar</div>";
    } else {
        // proibir cadastro duplicado
        $result_pg = "SELECT id FROM adms_paginas 
                        WHERE endereco ='".$dados_validos['endereco']."' 
                        AND adms_tps_pg_id = '".$dados_validos['adms_tps_pg_id']."'
                        AND id <> '".$dados['id']."' ";
        $resultado_pg = mysqli_query($conn, $result_pg);
        if(($resultado_pg) && ($resultado_pg->num_rows != 0 )){
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'> Esse endereço já está cadastrado</div>";
        }
    }

    if($erro) {
        $dados['obs'] = trim($dados_obs);
        $dados['icone'] = $dados_icone;
        $_SESSION['dados'] = $dados;
        $url_destino = pg.'/editar/edit_pagina?id='.$dados['id'];
        header("Location: $url_destino");
    } else {

        $result_upd_pg = "UPDATE adms_paginas SET 
                            nome_paginas = '".$dados_validos['nome_pagina']."',
                            endereco = '".$dados_validos['endereco']."',
                            obs = '".$dados_obs."',
                            keywords = '".$dados_validos['keywords']."',
                            description = '".$dados_validos['description']."',
                            author = '".$dados_validos['author']."',
                            lib_pub = '".$dados_validos['lib_pub']."',
                            icone = '".$dados_icone."',
                            depend_pg = '".$dados_validos['depend_pg']."',
                            adms_grps_pg_id = '".$dados_validos['adms_grps_pg_id']."',
                            adms_tps_pg_id = '".$dados_validos['adms_tps_pg_id']."',
                            adms_robot_id = '".$dados_validos['adms_robot_id']."',
                            adms_sits_pg_id = '".$dados_validos['adms_sits_pg_id']."',
                            modified = NOW()
                            WHERE id = '".$dados_validos['id']."'";
       $resultado_upd_pg = mysqli_query($conn, $result_upd_pg);

        
        if(mysqli_affected_rows($conn)) {
            unset($_SESSION['dados']);
            $_SESSION['msg'] = "<div class='alert alert-success'>página Editada com sucesso</div>";
            $url_destino = pg.'/listar/list_pagina';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao editar a página</div>";
            $url_destino = pg.'/processa/edit_pagina?id'.$dados['id'];
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
