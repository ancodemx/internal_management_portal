<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="<?php echo \app\Utils\DataSessionUtils::getUserFullName(); ?>">
                <i class="far fa-user"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <!-- User image -->
                <li class="user-header bg-primary" style="height: 57px;">
                    <p>
                        <small><?php echo \app\Utils\DataSessionUtils::getUserFullName(); ?></small>
                    </p>
                </li>

                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="#" class="btn btn-default btn-sm btn-flat">Perfil</a>
                    <a href="#" class="btn btn-default btn-sm btn-flat float-right" id="LogOutSession">Cerrar sesión</a>
                </li>
            </ul>
        </li>
    </ul>
        
</nav>
<!-- /.navbar --> 