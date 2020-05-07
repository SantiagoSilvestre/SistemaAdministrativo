<?php
if (!isset($seguranca)) {
    exit;
}
$SendCadLead = filter_input(INPUT_POST, 'SendCadLead', FILTER_SANITIZE_STRING);
if($SendCadLead){
    $email_rc = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email_st = strip_tags($email_rc);
    $email_tr = trim($email_st);
    if($email_tr != ""){
        $result_lead = "INSERT INTO sts_leads (email, created) VALUES ('$email_tr', NOW())";
        mysqli_query($conn, $result_lead);
        if(mysqli_insert_id($conn)){
            $url_destino = pg."/home";
            echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=$url_destino'>
                <script type=\"text/javascript\">
                        alert(\"E-mail cadastrado com Sucesso.\");
                </script>";
        }else{
            $url_destino = pg."/home";
            echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=$url_destino'>
                <script type=\"text/javascript\">
                        alert(\"Erro ao cadastrar o e-mail.\");
                </script>";
        }
    }else{
        $url_destino = pg."/home";
        echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=$url_destino'>
            <script type=\"text/javascript\">
                    alert(\"E-mail inválido.\");
            </script>";
    }
    
}else{
    $url_destino = pg."/home";
    header("Location: $url_destino");
}
