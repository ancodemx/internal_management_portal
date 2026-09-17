<!doctype html>
<html lang="en">
    <!-- [Head] start -->
    <head>
        <title><?php echo PROJECT_NAME; ?> | Inicioe</title>
        <!-- [Meta] -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />

        <!-- REQUIRED SCRIPTS -->
        <?php
        define('DATE_PICKER_CSS', 0);
        include PROJECT_PATH . 'views/includes/script-css.php';
        ?>

        <script type="text/javascript">
            let URL_PATH = "<?php echo URL_PATH; ?>";
        </script>

    </head>
    <!-- [Head] end -->
    
    <!-- [Body] Start -->
    <body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

        <!-- [ Pre-loader ] start -->
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
        <!-- [ Pre-loader ] End -->

        <?php
        include PROJECT_PATH . 'views/includes/left_sidebar_menu.php';
        include PROJECT_PATH . 'views/includes/header.php';
        ?>

        <!-- [ Main Content ] start -->
        <div class="pc-container">
            <div class="pc-content">
                <!-- [ breadcrumb ] start -->
                <div class="page-header">
                    <div class="page-block">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <div class="page-header-title">
                                    <h5 class="mb-0">Other-active</h5>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="/dashboard/index.html">Home</a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0)">Other</a></li>
                                    <li class="breadcrumb-item" aria-current="page">Other-active</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ breadcrumb ] end -->


                <!-- [ Main Content ] start -->
                <div class="row">
                    <!-- [ sample-page ] start -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Hello card</h5>
                            </div>
                            <div class="card-body"> </div>
                        </div>
                    </div>
                    <!-- [ sample-page ] end -->
                </div>
                <!-- [ Main Content ] end -->

            </div>
        </div>

        <?php
        //include PROJECT_PATH . 'views/includes/control_sidebar_right.php';
        include PROJECT_PATH . 'views/includes/footer.php';
        ?>
        
    </body>
    <!-- [Body] end -->

    <!-- REQUIRED SCRIPTS -->
    <?php
    define('DATE_PICKER_JS', 0);
    define('ADMINLTE', 0);
    include PROJECT_PATH . 'views/includes/script-js.php';
    ?>

</html>