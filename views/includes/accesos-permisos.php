<?php

foreach ($_SESSION["Data_Session"]["Menu_Perfil"] as $val) {
    foreach ($val["Opcion"] as $val2) {
        if ($val2["Metodo"] == $_SESSION["controlador"]) {
            $nombre_modulo = $val2["Opcion"];
            $acceso = 1;
            break 2;
        }else {
            $acceso = 0;
        }
    }
}


if ( $_SESSION["Data_Session"]["Datos_Usuario"]["CVE_COLABORADOR"] == "" || $_SESSION["Data_Session"]["Datos_Usuario"]["CVE_SISTEMA"] != 3 ) {
    //header("Location:login");
    die(header("Location:login"));
}

if ( $acceso == 0 ) {
   //header("Location:login");
    die(header("Location:login"));
}

?>

