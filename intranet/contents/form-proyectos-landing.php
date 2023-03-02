<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>SEGEBUCO SAC | Gestion de Servicios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Walga Inversiones | Transporte y Alquiler de Gruas" name="description"/>
    <meta content="" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.png">
    <!-- App css -->
    <link href="../assets/css/proyectLanding.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/metisMenu.min.css" rel="stylesheet" type="text/css"/>
    <link href="../plugins/daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/css/app.min.css" rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" media="all"/>

</head>
<body data-layout="horizontal" class="">

    <!-- Top Bar Start -->
    <?php require '../fixed/top-bar.php' ?>
    <!-- Top Bar End -->

    <form action="#" method="post" enctype="multipart/form-data">
        <div class="wrapper">
            <div class="container">
                <h1>Cargar Archivo</h1>

                <input type="text" name="titulo" id="titulo" placeholder="Nombre del Proyecto"><br><br>
                <input type="text" name="client" id="client" placeholder="Nombre del Cliente"><br><br>
                <label for="titulo">Fecha de Ejecución</label></br>
                <input type="date" name="date" id="date"><br><br>

                <!--label for="descripcion">Descripción del proyecto:</label--><br>
                <textarea name="descripcion" id="descripcion" rows="5" cols="40" placeholder="Descripcion del Proyecto"></textarea><br><br>

                <div class="upload-container">
                    <div class="border-container">
                        <div class="icons fa-4x">
                            <i class="fas fa-file-image" data-fa-transform="shrink-3 down-2 left-6 rotate--45"></i>
                            <i class="fas fa-file-alt" data-fa-transform="shrink-2 up-4"></i>
                            <i class="fas fa-file-pdf" data-fa-transform="shrink-3 down-2 right-6 rotate-45"></i>
                        </div>
                        <p>Arrastre y suelte archivos aquí</p>
                        <input type="file" id="file-upload">
                    </div>
                </div>
                <input type="submit" value="Subir Proyecto">
            </div>
        </div>

    </form>
</body>
</html>
