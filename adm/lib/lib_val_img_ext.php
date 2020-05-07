<?php

if (!isset($seg)) {
    exit;
}

function validarExtensao($foto) {
    switch ($foto) { 
        case 'image/png';
        case 'image/x-png';
            return true;
        case 'image/jpeg';
        case 'image/pjpeg'; 
            return true;
        default:
            return false;
    }
}
