<?php 
 session_start();
    require_once "./app/config/dependencias.php";
   
    require_once "./app/config/rutas.php";
?>
<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=CSS.'b5.css'?>">
    <link rel="stylesheet" href="<?=CSS.'font_awesome/all.css'?>">
    <link rel="stylesheet" href="<?=CSS.'dt.css'?>">
    <script src="<?=JS."font_awesome/all.js"?>"></script>
    <script src="<?=JS."jquery.js"?>"></script>
    <script src="<?=JS."sweetAlert.js"?>"></script>
    <script src="<?=JS."b5.js"?>"></script>
    <script src="<?=JS."dt.js"?>"></script>
    <title>ESCUELA</title>
</head>

<body>

<?php require_once './app/config/router.php';?> 
<?php require_once './views/components/navegacion.php';?>  

    <script src="./public/js/cerrar_sesion.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>