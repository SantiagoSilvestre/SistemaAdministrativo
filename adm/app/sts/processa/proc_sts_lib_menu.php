<?php

if (!isset($seg)) {
    exit;
}
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if ($id) {
    //Pesquisar os dados da tabela adms_nivacs_pgs
    $result_sts_pg = "SELECT lib_bloq
        FROM sts_paginas
        WHERE id='$id' LIMIT 1";
   
    $resultado_sts_pg = mysqli_query($conn, $result_sts_pg);

    //Retornou algum valor do banco de dados e acesso o IF, senão acessa o ELSe
    if (($resultado_sts_pg) AND ( $resultado_sts_pg->num_rows != 0)) {
        $row_sts_pg = mysqli_fetch_assoc($resultado_sts_pg);
        //Verificar o status da página e atribuir o inverso na variável status
        if ($row_sts_pg['lib_bloq'] == 1) {
            $status = 2;
        } else {
            $status = 1;
        }

        $result_sit_pg_up = "UPDATE sts_paginas SET
                lib_bloq='$status',
                modified=NOW()
                WHERE id='$id'";
        mysqli_query($conn, $result_sit_pg_up);
        if (mysqli_affected_rows($conn)) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Situação do menu editado com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_pagina';
            header("Location: $url_destino");
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A situação do menu não foi alterada com sucesso!</div>";
            $url_destino = pg . '/listar/sts_list_pagina';
            header("Location: $url_destino");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
        $url_destino = pg . '/listar/sts_list_pagina';
        header("Location: $url_destino");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Página não encontrada!</div>";
    $url_destino = pg . '/listar/sts_list_pagina';
    header("Location: $url_destino");
}
