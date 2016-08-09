<?php
    $f = $_GET["file"];
    if(strpos($f,"/")!==false){
        die("No puedes navegar por otros directorios");
    }
    header("Content-disposition: attachment; filename=$f");
    header("Content-type: application/octet-stream");
    readfile($f);
?>