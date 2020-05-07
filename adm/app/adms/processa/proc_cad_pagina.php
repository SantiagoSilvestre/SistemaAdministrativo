<?php
if (!isset($seg)) {
    exit;
}
$sendCadPg = filter_input(INPUT_POST, 'SendCadPg', FILTER_SANITIZE_STRING);

if($sendCadPg) {

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
        $_SESSION['msg'] = "<div class='alert alert-danger'> Necessário preencher todos os campos</div>";
    } else {
        // proibir cadastro duplicado
        $result_pg = "SELECT id FROM adms_paginas WHERE endereco ='".$dados_validos['endereco']."' AND adms_tps_pg_id = '".$dados_validos['adms_tps_pg_id']."' ";
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
        $url_destino = pg.'/cadastrar/cad_pagina';
        header("Location: $url_destino");
    } else {
        $result_cad_pg = "INSERT INTO adms_paginas
         (nome_paginas, endereco, obs, keywords, description, author, lib_pub, icone, depend_pg, adms_grps_pg_id, adms_tps_pg_id, adms_robot_id, adms_sits_pg_id, created)
         VALUES ('".$dados_validos['nome_pagina']."',
                    '".$dados_validos['endereco']."',
                    '".$dados_obs."',
                    '".$dados_validos['keywords']."',
                    '".$dados_validos['description']."',
                    '".$dados_validos['author']."',
                    '".$dados_validos['lib_pub']."', 
                    '".$dados_icone."',
                    '".$dados_validos['depend_pg']."',
                    '".$dados_validos['adms_grps_pg_id']."',
                    '".$dados_validos['adms_tps_pg_id']."',
                    '".$dados_validos['adms_robot_id']."',
                    '".$dados_validos['adms_sits_pg_id']."',
                     NOW())";
        mysqli_query($conn, $result_cad_pg);
        if(mysqli_insert_id($conn)) {
            unset($_SESSION['dados']);

            //Inicio inserir na tablea adms_nivac_pgs
            $pagina_id = mysqli_insert_id($conn);
            
            //Pesquisar os niveis de acesso
            $result_niv_acesso = "SELECT id, nome FROM adms_niveis_acesso";
            $resultado_niv_acesso = mysqli_query($conn, $result_niv_acesso);

            while($row_niv_acesso = mysqli_fetch_assoc($resultado_niv_acesso)) {
                // Determinar 1 na permissão caso seja superAdministrador e com outros nivel 2: = liberado
                if($row_niv_acesso['id'] == 1 ){
                    $permissao = 1;
                } else {
                    $permissão = 2;
                }
                //Pesquisar o maior numero da ordem na tabela
                $result_maior_ordem = "SELECT ordem FROM adms_nivacs_pgs WHERE adms_niveis_acesso_id='".$row_niv_acesso['id']."' 
                ORDER BY ordem desc LIMIT 1";
                $resultado_ordem_maior = mysqli_query($conn, $result_maior_ordem);
                $maior_ordem = mysqli_fetch_assoc($resultado_ordem_maior);
                $ordem = $maior_ordem['ordem'] +1;

                //Cadastrar permissão na tabela adms_nives paginas
                $result_cad_pg = "INSERT INTO adms_nivacs_pgs (permissao, ordem, dropdown, lib_menu, adms_menu_id, adms_niveis_acesso_id, adms_paginas_id, created ) 
                                      VALUES 
                                      (
                                          '".$permissao."',
                                          '".$ordem."',
                                          '1',
                                          '2',
                                          '3',
                                          '".$row_niv_acesso['id']."',
                                          '".$pagina_id."',
                                          NOW()
                                      )
                                    ";
                mysqli_query($conn, $result_cad_pg);
            }

            $_SESSION['msg'] = "<div class='alert alert-success'>página Cadastrada</div>";
            $url_destino = pg.'/listar/list_pagina';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'> ".$result_cad_pg." Erro ao inserir a página</div>";
            $url_destino = pg.'/cadastrar/cad_pagina';
            header("Location: $url_destino");
        }
    }

} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'> Página não encontrada</div>";
    unset($_SESSION['dados']);
    $url_destino = pg.'/acesso/login';
    header("Location: $url_destino");
}
