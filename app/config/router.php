<?php
    if(isset($_REQUEST['view'])){
        $vista = $_REQUEST['view'];
    }else{
        $vista = "inicio";
    }
    switch($vista){
        case "login":{
            require_once './views/login.php';
            break;
        }
        case "registro":{
            require_once './views/registro.php';
            break;
        }
        case "admin":{
            require_once './views/admin.php';
            break;
        }
        case "profesor":{
            require_once './views/profesor.php';
            break;
        }case "calificaciones":{
            require_once './views/Calificaciones.php';
            break;
        }case "alumno":{
            require_once './views/alumno.php';
            break;
        }case "registroAlumno":{
            require_once './views/registroAlumno.php';
            break;
        }
        default:{
            require_once './views/error404.php';
            break;
        }
    }
?> 