<?php

session_start();
$seg = true;
require '../../../config/conexao.php';
require '../../../config/config.php';

//Receber a requisão da pesquisa 
$requestData = $_REQUEST;

//Indice da coluna na tabela visualizar resultado => nome da coluna no banco de dados
$columns = array(
    0 => 'id',
    1 => 'nome',
    2 => 'email',
    3 => 'nome_nivac',
    4 => 'botao'
);

//Obtendo registros de número total sem qualquer pesquisa
$result_pg = "SELECT COUNT(id) AS num_result FROM adms_usuarios";
$resultado_pg = mysqli_query($conn, $result_pg);
$qnt_linhas = mysqli_fetch_assoc($resultado_pg);

//Obter os dados a serem apresentados
//$result_usuarios = "SELECT id, nome, email, adms_sits_usuario_id FROM adms_usuarios WHERE 1=1";
if ($_SESSION['adms_niveis_acesso_id'] == 1) {
    $result_usuarios = "SELECT user.id, user.nome, user.email,
            nivac.nome nome_nivac
            FROM adms_usuarios user
            INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
            WHERE 1=1";
            
} else {
    $result_usuarios = "SELECT user.id, user.nome, user.email,
            nivac.nome nome_nivac
            FROM adms_usuarios user
            INNER JOIN adms_niveis_acessos nivac ON nivac.id=user.adms_niveis_acesso_id
            WHERE nivac.ordem > '" . $_SESSION['ordem'] . "'";
}


if (!empty($requestData['search']['value'])) {   // se houver um parâmetro de pesquisa, $requestData['search']['value'] contém o parâmetro de pesquisa
    $result_usuarios .= " AND ( user.id LIKE '%" . $requestData['search']['value'] . "%' ";
    $result_usuarios .= " OR user.nome LIKE '%" . $requestData['search']['value'] . "%' ";
    $result_usuarios .= " OR user.email LIKE '%" . $requestData['search']['value'] . "%' ";
    $result_usuarios .= " OR nivac.nome LIKE '%" . $requestData['search']['value'] . "%' )";
}

$resultado_usuarios = mysqli_query($conn, $result_usuarios);
$totalFiltered = mysqli_num_rows($resultado_usuarios);
//Ordenar o resultado
$result_usuarios .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "  LIMIT " . $requestData['start'] . " ," . $requestData['length'] . "   ";
$resultado_usuarios = mysqli_query($conn, $result_usuarios);

require '../../../lib/lib_permissao.php';

//Validar botão
$btn_vis = carregarBtn('visualizar/vis_usuario', $conn);
$btn_edit = carregarBtn('editar/edit_usuario', $conn);
$btn_apagar = carregarBtn('processa/apagar_usuario', $conn);
$btn_vis_val = "";
$btn_edit_val = "";
$btn_apagar_val = "";
// Ler e criar o array de dados
$dados = array();
while ($row_usuarios = mysqli_fetch_array($resultado_usuarios)) {
    $dado = array();
    $dado[] = $row_usuarios["id"];
    $dado[] = $row_usuarios["nome"];
    $dado[] = $row_usuarios["email"];
    $dado[] = $row_usuarios["nome_nivac"];
    if ($btn_vis) {
        $btn_vis_val =  "<a href='" . pg . "/visualizar/vis_usuario?id=" . $row_usuarios['id'] . "' class='btn btn-outline-primary btn-sm'>Visualizar</a> ";
    }
    if ($btn_edit) {
        $btn_edit_val = "<a href='" . pg . "/editar/edit_usuario?id=" . $row_usuarios['id'] . "' class='btn btn-outline-warning btn-sm'>Editar </a> ";
    }
    if ($btn_apagar) {
        $btn_apagar_val = "<a href='" . pg . "/processa/apagar_usuario?id=" . $row_usuarios['id'] . "' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a> ";
    }
    $dado[] = $btn_vis_val . $btn_edit_val . $btn_apagar_val;
    $dados[] = $dado;
}

//Cria o array de informações a serem retornadas para o Javascript
$json_data = array(
    "draw" => intval($requestData['draw']), //para cada requisição é enviado um número como parâmetro
    "recordsTotal" => intval($qnt_linhas), //Quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($totalFiltered), //Total de registros quando houver pesquisa
    "data" => $dados   //Array de dados completo dos dados retornados da tabela 
);

echo json_encode($json_data);  //enviar dados como formato json
