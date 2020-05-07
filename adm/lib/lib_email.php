<?php
if(!isset($seg)){
    exit;
}
function validarEmail($email){
    $condicao = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';
    if(preg_match($condicao, $email)){
        return true;
    }else{
        return false;
    }    
}
