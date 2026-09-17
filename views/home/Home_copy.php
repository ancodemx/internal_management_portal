<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo PROJECT_NAME; ?> | Inicio</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- REQUIRED SCRIPTS -->
    <?php
    define('TOASTR', 0);
    define('DATATABLE', 0);
    define('SUMMERNOTE', 0);
    define('DATE_PICKER', 0);
    define('DATE_PICKER_CSS', 0);
    define('SELECT2', 0);
    define('LOADING', 0);
    include PROJECT_PATH . 'views/includes/script-css.php';
    ?>

    <script type="text/javascript">
        let URL_PATH = "<?php echo URL_PATH; ?>";
    </script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include PROJECT_PATH . 'views/includes/header_copy.php';
        include PROJECT_PATH . 'views/includes/left_sidebar_menu_copy.php';
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">

            <div class="nav navbar navbar-expand navbar-white navbar-light border-bottom p-0" style="font-size: 12px;">
                <div class="nav-item dropdown">
                    <a class="nav-link bg-primary dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
                    <div class="dropdown-menu mt-0">
                        <a class="dropdown-item" href="#" data-widget="iframe-close" data-type="all" style="font-size: 12px;">Cerrar tabs</a>
                    </div>
                </div>
                <a class="nav-link bg-light" href="#" data-widget="iframe-scrollleft"><i class="fas fa-angle-double-left"></i></a>
                <ul class="navbar-nav overflow-hidden" role="tablist"></ul>
                <a class="nav-link bg-light" href="#" data-widget="iframe-scrollright"><i class="fas fa-angle-double-right"></i></a>
                <a class="nav-link bg-light" href="#" data-widget="iframe-fullscreen"><i class="fas fa-expand"></i></a>
            </div>

            <div class="tab-content">
                <!-- <div class="tab-empty">
                    <h2 class="display-4">No hay tabs activos</h2>
                </div> -->
                <div class="tab-loading">
                    <div>
                        <h3>Cargando <i class="fa fa-sync fa-spin"></i></h3>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.content-wrapper -->

        <?php
        //include PROJECT_PATH . 'views/includes/control_sidebar_right.php';
        //include PROJECT_PATH . 'views/includes/footer.php';
        ?>
    </div>
    <!-- ./wrapper -->

</body>

<!-- REQUIRED SCRIPTS -->
<?php
define('BOOTBOX', 1);
define('FILES', 0);
define('DATE_PICKER_JS', 0);
define('ADMINLTE', 0);
define('INPUTMASK', 0);
include PROJECT_PATH . 'views/includes/script-js.php';
?>

<script type="text/javascript">

        $(document).ready(function() {

            window.addEventListener('message', function(event) {
                if (event.data && event.data.action === 'logout') {
                    window.location.href = URL_PATH + 'login'; // o la ruta de tu login
                }
            });

        });

    </script>

</html>